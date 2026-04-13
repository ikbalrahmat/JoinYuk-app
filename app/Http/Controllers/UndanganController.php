<?php

namespace App\Http\Controllers;

use App\Models\Undangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UndanganController extends Controller
{
    public function index()
    {
        // cuma tampilin view, data diambil via fetch JS
        return view('pages.undangan.index');
    }

    public function getData()
    {
        // ambil undangan khusus user yang login
        $undangan = Undangan::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'data' => $undangan
        ]);
    }

    public function create()
    {
        return view('pages.undangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kepada' => 'required|string',
            'pengirim' => 'required|string',
            'tempat_link' => 'required|string',
            'agenda' => 'required|string',
            'tanda_tangan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        // Simpan tanda tangan base64 ke file PNG
        if (!empty($validated['tanda_tangan'])) {
            $folderPath = storage_path('app/public/signatures/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $image_parts = explode(";base64,", $validated['tanda_tangan']);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $filePath = $folderPath . $fileName;
            file_put_contents($filePath, $image_base64);

            // simpan path relatif ke database
            $validated['tanda_tangan'] = 'signatures/' . $fileName;
        }

        Undangan::create($validated);

        return redirect()->route('undangan.index')->with('success', 'Undangan rapat berhasil ditambahkan!');
    }

        public function edit(Undangan $undangan)
    {
        $this->authorizeAccess($undangan);
        return view('pages.undangan.edit', compact('undangan'));
    }

    public function update(Request $request, Undangan $undangan)
    {
        $this->authorizeAccess($undangan);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kepada' => 'required|string',
            'pengirim' => 'required|string',
            'tempat_link' => 'required|string',
            'agenda' => 'required|string',
            'tanda_tangan' => 'nullable|string',
        ]);

        if (!empty($validated['tanda_tangan'])) {
            $folderPath = storage_path('app/public/signatures/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $image_parts = explode(";base64,", $validated['tanda_tangan']);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $filePath = $folderPath . $fileName;
            file_put_contents($filePath, $image_base64);

            $validated['tanda_tangan'] = 'signatures/' . $fileName;
        } else {
            unset($validated['tanda_tangan']);
        }

        $undangan->update($validated);

        return redirect()->route('undangan.index')->with('success', 'Undangan rapat berhasil diupdate!');
    }

    public function destroy(Undangan $undangan)
    {
        $this->authorizeAccess($undangan);
        $undangan->delete();

        return redirect()->route('undangan.index')->with('success', 'Undangan rapat berhasil dihapus!');
    }

    public function preview(Undangan $undangan)
    {
        $this->authorizeAccess($undangan);
        return view('pages.undangan.preview_modal', compact('undangan'));
    }

    public function exportPdf(Undangan $undangan)
    {
        $this->authorizeAccess($undangan);
        $pdf = Pdf::loadView('pages.undangan.pdf', compact('undangan'))
                  ->setPaper('a4', 'portrait');
        return $pdf->download("undangan-rapat-{$undangan->id}.pdf");
    }

    private function authorizeAccess(Undangan $undangan)
    {
        if ($undangan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
