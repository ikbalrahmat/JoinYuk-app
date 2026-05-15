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

    public function choose()
    {
        $templates = Presence::where('created_by', auth()->id())->latest()->get();
        return view('pages.presence.choose', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $templateData = null;
        if ($request->template_id) {
            $templateData = Presence::where('id', $request->template_id)
                ->where('created_by', auth()->id())
                ->first();
        }
        
        $formName = $request->name ?? 'Untitled Form';
        $formType = $request->type ?? 'standard';
        
        return view('pages.presence.create', compact('templateData', 'formName', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
        ]);

        $presence = new Presence();
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug = Str::slug($request->nama_kegiatan);
        
        if ($request->tgl_kegiatan || $request->waktu_mulai) {
            $presence->tgl_kegiatan = trim($request->tgl_kegiatan . ' ' . $request->waktu_mulai);
        } else {
            $presence->tgl_kegiatan = null;
        }
        $presence->tempat = $request->tempat;
        $presence->created_by = auth()->id();
        
        if ($request->has('custom_fields')) {
            $presence->custom_fields = json_decode($request->custom_fields, true);
        }

        if ($request->has('header_config')) {
            $headerConfig = json_decode($request->header_config, true);
            
            // Process Logo Kiri
            if (!empty($headerConfig['logo_left']) && strpos($headerConfig['logo_left'], 'data:image') === 0) {
                $base64_image = $headerConfig['logo_left'];
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);
                $logoPath = "logos/" . date('YmdHis') . uniqid() . ".png";
                Storage::disk('public')->put($logoPath, base64_decode($file_data));
                $headerConfig['logo_left'] = $logoPath;
            }
            
            // Process Logo Kanan
            if (!empty($headerConfig['logo_right']) && strpos($headerConfig['logo_right'], 'data:image') === 0) {
                $base64_image = $headerConfig['logo_right'];
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);
                $logoPath = "logos/" . date('YmdHis') . uniqid() . ".png";
                Storage::disk('public')->put($logoPath, base64_decode($file_data));
                $headerConfig['logo_right'] = $logoPath;
            }
            
            $presence->header_config = json_encode($headerConfig);
        }

        $presence->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success', 
                'message' => 'Formulir berhasil disimpan!',
                'redirect' => route('presence.edit', $presence->id)
            ]);
        }

        return redirect()->route('presence.edit', $presence->id)->with('success', 'Formulir berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, PresenceDetailsDataTable $dataTable)
    {
        $presence = Presence::findOrFail($id);
        return $dataTable->setPresenceId((int) $presence->id)->render('pages.presence.detail.index', compact('presence'));
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
        ]);

        $presence = Presence::findOrFail($id);
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug = Str::slug($request->nama_kegiatan);

        if ($request->tgl_kegiatan || $request->waktu_mulai) {
            $presence->tgl_kegiatan = trim($request->tgl_kegiatan . ' ' . $request->waktu_mulai);
        } else {
            $presence->tgl_kegiatan = null;
        }
        $presence->tempat = $request->tempat;
        $presence->created_by = auth()->id();
        
        if ($request->has('custom_fields')) {
            $presence->custom_fields = json_decode($request->custom_fields, true);
        }

        if ($request->has('header_config')) {
            $headerConfig = json_decode($request->header_config, true);
            
            // Process Logo Kiri
            if (!empty($headerConfig['logo_left']) && strpos($headerConfig['logo_left'], 'data:image') === 0) {
                $base64_image = $headerConfig['logo_left'];
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);
                $logoPath = "logos/" . date('YmdHis') . uniqid() . ".png";
                Storage::disk('public')->put($logoPath, base64_decode($file_data));
                $headerConfig['logo_left'] = $logoPath;
            }
            
            // Process Logo Kanan
            if (!empty($headerConfig['logo_right']) && strpos($headerConfig['logo_right'], 'data:image') === 0) {
                $base64_image = $headerConfig['logo_right'];
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);
                $logoPath = "logos/" . date('YmdHis') . uniqid() . ".png";
                Storage::disk('public')->put($logoPath, base64_decode($file_data));
                $headerConfig['logo_right'] = $logoPath;
            }
            
            $presence->header_config = json_encode($headerConfig);
        }

        $presence->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success', 
                'message' => 'Formulir berhasil diperbarui!'
            ]);
        }

        return redirect()->route('presence.edit', $presence->id)->with('success', 'Formulir berhasil diperbarui!');
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

        $presence->bukti_kegiatan = null;
        $presence->save();

        return back()->with('success', 'Bukti kegiatan berhasil dihapus!');
    }


}
