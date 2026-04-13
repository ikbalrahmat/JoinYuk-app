<?php

namespace App\Http\Controllers;

use App\Models\Risalah;
use App\Models\Undangan;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Snappy\Facades\SnappyPdf;

class RisalahController extends Controller
{
    public function index()
    {
        // hanya tampilkan risalah milik user login
        $risalahs = Risalah::with('undangan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.risalah.index', compact('risalahs'));
    }

    public function create()
    {
        // hanya ambil undangan & absensi milik user login
        $undangans = Undangan::where('user_id', Auth::id())->get();
        $presences = Presence::where('created_by', Auth::id())->get();

        return view('pages.risalah.create', compact('undangans', 'presences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'undangan_id' => 'required|exists:undangan,id',
            'presence_id' => 'required|exists:presences,id',
            'pimpinan'    => 'required|string|max:255',
            'pencatat'    => 'required|string|max:255',
            'jenis_rapat' => 'nullable|string',
            'penjelasan'  => 'nullable|string',
            'kesimpulan'  => 'nullable|string',
        ]);

        // pastikan undangan & presence milik user login
        $undangan = Undangan::where('id', $request->undangan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $presence = Presence::where('id', $request->presence_id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        Risalah::create([
            'undangan_id'   => $undangan->id,
            'presence_id'   => $presence->id,
            'agenda'        => $undangan->agenda,
            'tanggal'       => $undangan->tanggal,
            'waktu_mulai'   => $undangan->jam,
            'waktu_selesai' => null,
            'tempat'        => $undangan->tempat_link,
            'pimpinan'      => $request->pimpinan,
            'pencatat'      => $request->pencatat,
            'jenis_rapat'   => $request->jenis_rapat,
            'penjelasan'    => $request->penjelasan,
            'kesimpulan'    => $request->kesimpulan,
            'user_id'       => Auth::id(),
        ]);

        return redirect()->route('risalah.index')->with('success', 'Risalah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $risalah = Risalah::with(['undangan', 'presence'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json($risalah);
    }

    public function edit($id)
    {
        $risalah = Risalah::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // hanya data milik user login
        $undangans = Undangan::where('user_id', Auth::id())->get();
        $presences = Presence::where('created_by', Auth::id())->get();

        return view('pages.risalah.edit', compact('risalah', 'undangans', 'presences'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'undangan_id' => 'required|exists:undangan,id',
            'presence_id' => 'required|exists:presences,id',
            'pimpinan'    => 'required|string|max:255',
            'pencatat'    => 'required|string|max:255',
            'jenis_rapat' => 'nullable|string',
            'penjelasan'  => 'nullable|string',
            'kesimpulan'  => 'nullable|string',
        ]);

        $risalah = Risalah::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // pastikan undangan & presence milik user login
        $undangan = Undangan::where('id', $request->undangan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $presence = Presence::where('id', $request->presence_id)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        $risalah->update([
            'undangan_id'   => $undangan->id,
            'presence_id'   => $presence->id,
            'agenda'        => $undangan->agenda,
            'tanggal'       => $undangan->tanggal,
            'waktu_mulai'   => $undangan->jam,
            'waktu_selesai' => null,
            'tempat'        => $undangan->tempat_link,
            'pimpinan'      => $request->pimpinan,
            'pencatat'      => $request->pencatat,
            'jenis_rapat'   => $request->jenis_rapat,
            'penjelasan'    => $request->penjelasan,
            'kesimpulan'    => $request->kesimpulan,
            'user_id'       => Auth::id(),
        ]);

        return redirect()->route('risalah.index')->with('success', 'Risalah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $risalah = Risalah::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $risalah->delete();
        return redirect()->route('risalah.index')->with('success', 'Risalah berhasil dihapus.');
    }

    public function export($id)
    {
        $risalah = Risalah::with(['undangan', 'presence'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $presenceDetails = PresenceDetail::where('presence_id', $risalah->presence_id)->get();

        $pdf = SnappyPdf::loadView('pages.risalah.pdf', compact('risalah', 'presenceDetails'))
            ->setOption('margin-top', 15)
            ->setOption('margin-bottom', 15)
            ->setOption('margin-left', 15)
            ->setOption('margin-right', 15)
            ->setOption('page-size', 'A4')
            ->setOption('encoding', 'UTF-8');

        return $pdf->download('risalah-' . $risalah->id . '.pdf');
    }

    public function preview($id)
    {
        $risalah = Risalah::with(['undangan', 'presence'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $presenceDetails = PresenceDetail::where('presence_id', $risalah->presence_id)->get();

        return view('pages.risalah.pdf', compact('risalah', 'presenceDetails'));
    }
}
