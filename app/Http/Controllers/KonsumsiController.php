<?php

namespace App\Http\Controllers;

use App\Models\Konsumsi;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class KonsumsiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole(['super_admin', 'admin'])) {
            // Admin bisa lihat semua
            $konsumsis = Konsumsi::orderBy('created_at', 'desc')->get();
        } elseif ($user->hasRole('yanum')) {
            // Ambil nama lokasi dari unit kerja Yanum, contoh: "Yanum Karawang" diubah menjadi "Karawang"
            $lokasiYanum = trim(str_replace('Yanum', '', $user->unit_kerja));

            // Yanum hanya akan melihat data pesanan yang lokasi_unit_kerjanya cocok dengan lokasi yanum tersebut
            $konsumsis = Konsumsi::where('lokasi_unit_kerja', $lokasiYanum)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // User biasa hanya lihat data dia sendiri
            $konsumsis = Konsumsi::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pages.konsumsi.index', compact('konsumsis'));
    }

    public function create()
    {
        $unitKerjas = Anggaran::pluck('nama_unit_kerja')->unique();
        return view('pages.konsumsi.create', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pemesan'          => 'required|string|max:255',
            'nomor_surat_nde'       => 'required|string|max:255',
            'jumlah_peserta'        => 'required|integer|min:1',
            'layout_ruangan'        => 'required|string|max:255',
            'unit_kerja'            => 'required|string|max:255',
            'tahun_anggaran_rapat'  => 'required|integer',
            'agenda_rapat'          => 'required|string',
            'tanggal_rapat'         => 'required|date',
            'jam_rapat'             => 'required',
            'unggah_dokumen_nde'    => 'nullable|file|mimes:pdf|max:2048',
            'menu_konsumsi'         => 'required|array|min:1',
            'menu_konsumsi.*.menu'  => 'required|string',
            'menu_konsumsi.*.detail'=> 'nullable|string',
            'menu_konsumsi.*.jumlah'=> 'required|integer|min:1',
            'distribusi_tujuan'     => 'required|string',
            'lokasi_unit_kerja'     => 'required|string',
            'catatan'               => 'nullable|string',
        ]);

        if ($request->hasFile('unggah_dokumen_nde')) {
            $validatedData['unggah_dokumen_nde'] = $request->file('unggah_dokumen_nde')->store('documents', 'public');
        }

        // kalau bukan admin/yanum, cek anggaran
        if (!Auth::user()->hasRole(['super_admin', 'admin', 'yanum'])) {
            $anggaran = Anggaran::whereRaw('LOWER(TRIM(nama_unit_kerja)) = ?', [strtolower(trim($validatedData['unit_kerja']))])
                ->where('tahun_anggaran', $validatedData['tahun_anggaran_rapat'])
                ->first();

            if (!$anggaran) {
                return redirect()->back()->withInput()->with('error', 'Anggaran untuk unit kerja dan tahun tersebut tidak ditemukan.');
            }
        }

        $validatedData['status'] = 'Menunggu';
        $validatedData['total_biaya'] = null;
        $validatedData['user_id'] = Auth::id();
        $validatedData['role_tujuan'] = 'yanum'; // Simpan role tujuan yang generik

        Konsumsi::create($validatedData);

        return redirect()->route('konsumsi.index')->with('success', 'Pemesanan konsumsi berhasil diajukan!');
    }

    public function show(Konsumsi $konsumsi)
    {
        $user = Auth::user();

        if ($user->hasRole(['super_admin', 'admin'])) {
            return view('pages.konsumsi.show', compact('konsumsi'));
        }

        if ($user->hasRole('yanum')) {
             // Ambil nama lokasi dari unit kerja Yanum
            $lokasiYanum = trim(str_replace('Yanum', '', $user->unit_kerja));
            if ($konsumsi->lokasi_unit_kerja !== $lokasiYanum) {
                abort(403, 'Akses ditolak.');
            }
        } else {
            if ($konsumsi->user_id !== $user->id) {
                abort(403, 'Akses ditolak.');
            }
        }

        return view('pages.konsumsi.show', compact('konsumsi'));
    }

    public function edit(Konsumsi $konsumsi)
    {
        if (!Auth::user()->hasRole(['super_admin', 'admin', 'yanum'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        $anggaran = Anggaran::whereRaw('LOWER(TRIM(nama_unit_kerja)) = ?', [strtolower(trim($konsumsi->unit_kerja))])
            ->where('tahun_anggaran', $konsumsi->tahun_anggaran_rapat)
            ->first();

        return view('pages.konsumsi.edit', compact('konsumsi', 'anggaran'));
    }

    public function update(Request $request, Konsumsi $konsumsi)
    {
        if (!Auth::user()->hasRole(['super_admin', 'admin', 'yanum'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Selesai,Ditolak',
            'unggah_dokumen_nde' => 'nullable|file|mimes:pdf|max:2048',
            'menu_konsumsi' => 'required|array|min:1',
            'menu_konsumsi.*.menu' => 'nullable|string',
            'menu_konsumsi.*.detail' => 'nullable|string',
            'menu_konsumsi.*.jumlah' => 'nullable|integer|min:1',
            'menu_konsumsi.*.biaya' => 'nullable|numeric|min:0',
        ]);

        $total_biaya_dari_menu = collect($request->input('menu_konsumsi'))->sum('biaya');

        DB::beginTransaction();
        try {
            $anggaran = Anggaran::whereRaw('LOWER(TRIM(nama_unit_kerja)) = ?', [strtolower(trim($konsumsi->unit_kerja))])
                ->where('tahun_anggaran', $konsumsi->tahun_anggaran_rapat)
                ->lockForUpdate()
                ->first();

            $oldStatus = $konsumsi->status;
            $oldBiaya = (float) $konsumsi->total_biaya;
            $newStatus = $request->status;
            $newBiaya = $total_biaya_dari_menu;

            if ($anggaran) {
                if ($newStatus === 'Disetujui' && $oldStatus !== 'Disetujui') {
                    if ($anggaran->saldo_saat_ini < $newBiaya) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Saldo anggaran tidak mencukupi.');
                    }
                    $anggaran->saldo_saat_ini -= $newBiaya;
                    $anggaran->save();
                }

                if ($oldStatus === 'Disetujui' && $newStatus !== 'Disetujui') {
                    $anggaran->saldo_saat_ini += $oldBiaya;
                    $anggaran->save();
                }

                if ($oldStatus === 'Disetujui' && $newStatus === 'Disetujui' && $oldBiaya !== $newBiaya) {
                    $selisih = $newBiaya - $oldBiaya;
                    if ($selisih > 0 && $anggaran->saldo_saat_ini < $selisih) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Saldo anggaran tidak mencukupi untuk perubahan biaya.');
                    }
                    $anggaran->saldo_saat_ini -= $selisih;
                    $anggaran->save();
                }
            }

            $konsumsi->update([
                'total_biaya' => $newBiaya,
                'status' => $newStatus,
                'unggah_dokumen_nde' => $konsumsi->unggah_dokumen_nde,
                'menu_konsumsi' => $request->menu_konsumsi,
            ]);

            DB::commit();
            return redirect()->route('konsumsi.index')->with('success', 'Pemesanan berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal update konsumsi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses update.');
        }
    }

    public function destroy(Konsumsi $konsumsi)
    {
        if (!Auth::user()->hasRole(['super_admin', 'admin', 'yanum']) &&
            ($konsumsi->status !== 'Menunggu' || $konsumsi->user_id !== Auth::id())) {
            return redirect()->route('konsumsi.index')->with('error', 'Tidak bisa menghapus pesanan ini.');
        }

        $konsumsi->delete();
        return redirect()->route('konsumsi.index')->with('success', 'Pemesanan berhasil dihapus!');
    }

    public function exportPdf(Konsumsi $konsumsi)
    {
        $pdf = PDF::loadView('pages.konsumsi.pdf', compact('konsumsi'));
        return $pdf->download('pesanan-konsumsi-' . $konsumsi->id . '.pdf');
    }
}
