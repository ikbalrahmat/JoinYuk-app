<?php

namespace App\Http\Controllers;

use App\DataTables\AbsenDataTable;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index($slug, AbsenDataTable $dataTable)
    {
        $presence = Presence::where('slug', $slug)->firstOrFail();
        return $dataTable->render('pages.absen.index', compact('presence'));
    }

    public function save(Request $request, string $id)
    {
        $presence = Presence::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'np' => 'nullable|string|max:255', // Boleh kosong, tapi tetap valid string
            'jabatan' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'signature' => 'required',
        ]);

        $presenceDetail = new PresenceDetail();
        $presenceDetail->presence_id = $presence->id;
        $presenceDetail->nama = $request->nama;
        $presenceDetail->np = $request->np;
        $presenceDetail->jabatan = $request->jabatan;
        $presenceDetail->asal_instansi = $request->asal_instansi;

        // Decode base64 tanda tangan
        $base64_image = $request->signature;
        @list($type, $file_data) = explode(';', $base64_image);
        @list(, $file_data) = explode(',', $file_data);

        $uniqChar = date('YmdHis') . uniqid();
        $signaturePath = "tanda-tangan/{$uniqChar}.png";

        // Simpan ke disk uploads (pastikan 'public_uploads' diset di config/filesystems.php)
        Storage::disk('public_uploads')->put($signaturePath, base64_decode($file_data));

        $presenceDetail->tanda_tangan = $signaturePath;
        $presenceDetail->save();

        return redirect()->back()->with('success', 'Absen berhasil disimpan.');
    }
}
