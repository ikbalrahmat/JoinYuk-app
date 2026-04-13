<?php

namespace App\Http\Controllers;

use App\DataTables\PresenceDetailsDataTable;
use App\DataTables\PresencesDataTable;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PresencesDataTable $dataTable)
    {
        return $dataTable->render('pages.presence.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.presence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'waktu_mulai' => 'required',
        ]);

        $presence = new Presence();
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug = Str::slug($request->nama_kegiatan);
        $presence->tgl_kegiatan = $request->tgl_kegiatan . ' ' . $request->waktu_mulai;
        $presence->tempat = $request->tempat;
        $presence->created_by = auth()->id();
        $presence->save();

        return redirect()->route('presence.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, PresenceDetailsDataTable $dataTable)
    {
        $presence = Presence::findOrFail($id);
        return $dataTable->render('pages.presence.detail.index', compact('presence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presence = Presence::findOrFail($id);
        return view('pages.presence.edit', compact('presence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'waktu_mulai' => 'required',
            'tempat' => 'required',
        ]);

        $presence = Presence::findOrFail($id);
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug = Str::slug($request->nama_kegiatan);
        $presence->tgl_kegiatan = $request->tgl_kegiatan . ' ' . $request->waktu_mulai;
        $presence->tempat = $request->tempat;
        $presence->created_by = auth()->id();
        $presence->save();

        return redirect()->route('presence.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete data detail absen
        $presenceDetail = PresenceDetail::where('presence_id', $id)->get();
        foreach ($presenceDetail as $pd) {
            if ($pd->tanda_tangan) {
                Storage::disk('public_uploads')->delete($pd->tanda_tangan);
            }
            $pd->delete();
        }

        // Delete kegiatan
        Presence::destroy($id);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    }

    /**
     * Upload bukti kegiatan (gambar).
     */

     public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_kegiatan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $presence = Presence::findOrFail($id);

        // Simpan gambar ke storage/app/public/bukti
        $path = $request->file('bukti_kegiatan')->store('bukti', 'public');
        $filename = basename($path);

        $presence->bukti_kegiatan = $filename;
        $presence->save();

        return redirect()->back()->with('success', 'Bukti kegiatan berhasil diupload.');
    }


    public function deleteBukti($id)
    {
        $presence = Presence::findOrFail($id);

        if ($presence->bukti_kegiatan && Storage::disk('public')->exists('bukti/' . $presence->bukti_kegiatan)) {
            Storage::disk('public')->delete('bukti/' . $presence->bukti_kegiatan);
        }

        $presence->update(['bukti_kegiatan' => null]);

        return back()->with('success', 'Bukti kegiatan berhasil dihapus!');
    }


}
