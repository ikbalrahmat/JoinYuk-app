<?php

namespace App\Http\Controllers;

use App\DataTables\AbsenDataTable;
use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index($slug)
    {
        $presence = Presence::where('slug', $slug)->firstOrFail();
        return view('pages.absen.index', compact('presence'));
    }

    public function save(Request $request, string $id)
    {
        $presence = Presence::findOrFail($id);

        if (is_null($presence->custom_fields)) {
            // LAMA (Backward Compatibility)
            $request->validate([
                'nama' => 'required|string|max:255',
                'np' => 'nullable|string|max:255',
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

            $base64_image = $request->signature;
            @list($type, $file_data) = explode(';', $base64_image);
            @list(, $file_data) = explode(',', $file_data);

            $uniqChar = date('YmdHis') . uniqid();
            $signaturePath = "tanda-tangan/{$uniqChar}.png";

            Storage::disk('public_uploads')->put($signaturePath, base64_decode($file_data));

            $presenceDetail->tanda_tangan = $signaturePath;
            $presenceDetail->save();
        } else {
            // BARU (Custom Fields)
            $rules = [];
            foreach ($presence->custom_fields as $field) {
                if ($field['required']) {
                    $rules["dynamic.{$field['id']}"] = 'required';
                }
            }
            $request->validate($rules, [
                'dynamic.*.required' => 'Kolom ini wajib diisi'
            ]);

            $dynamicData = $request->input('dynamic', []);
            
            // Proses signature uploads if any
            foreach ($presence->custom_fields as $field) {
                if ($field['type'] === 'signature' && !empty($dynamicData[$field['id']])) {
                    $base64_image = $dynamicData[$field['id']];
                    @list($type, $file_data) = explode(';', $base64_image);
                    @list(, $file_data) = explode(',', $file_data);

                    $uniqChar = date('YmdHis') . uniqid();
                    $signaturePath = "tanda-tangan/{$uniqChar}.png";

                    Storage::disk('public_uploads')->put($signaturePath, base64_decode($file_data));
                    
                    // Ganti base64 dengan path gambar
                    $dynamicData[$field['id']] = $signaturePath;
                }
            }

            $presenceDetail = new PresenceDetail();
            $presenceDetail->presence_id = $presence->id;
            $presenceDetail->additional_data = $dynamicData;
            $presenceDetail->save();
        }

        return redirect()->route('absen.success', $presence->slug)->with('success', 'Absen berhasil disimpan.');
    }

    public function success($slug, AbsenDataTable $dataTable)
    {
        $presence = Presence::where('slug', $slug)->firstOrFail();
        return $dataTable->render('pages.absen.success', compact('presence'));
    }
}
