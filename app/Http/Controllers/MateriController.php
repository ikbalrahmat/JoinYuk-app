<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Undangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Tampilkan daftar materi.
     */
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            // Admin bisa lihat semua materi
            $materis = Materi::with('undangan', 'user')->latest()->paginate(10);
        } else {
            // User biasa hanya lihat materi yang dia buat
            $materis = Materi::with('undangan', 'user')
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10);
        }

        return view('pages.materi.index', compact('materis'));
    }

    /**
     * Tampilkan form tambah materi.
     */
    public function create()
    {
        if (auth()->user()->hasRole('Admin')) {
            $undangans = Undangan::all();
        } else {
            // User biasa hanya bisa pilih undangan miliknya
            $undangans = Undangan::where('user_id', auth()->id())->get();
        }

        return view('pages.materi.create', compact('undangans'));
    }

    /**
     * Simpan materi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'undangan_id' => 'required|exists:undangan,id',
            'judul'       => 'required|string|max:255',
            'file_materi' => 'required|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);

        $filePath = $request->file('file_materi')->store('materi', 'public');

        Materi::create([
            'undangan_id' => $request->undangan_id,
            'judul'       => $request->judul,
            'file_path'   => $filePath,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail materi.
     */
    public function show(Materi $materi)
    {
        // Batasi akses: user lain ga bisa buka materi yang bukan miliknya
        if (!auth()->user()->hasRole('Admin') && $materi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses ke materi ini.');
        }

        return view('pages.materi.show', compact('materi'));
    }

    /**
     * Tampilkan form edit materi.
     */
    public function edit(Materi $materi)
    {
        if (!auth()->user()->hasRole('Admin') && $materi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk mengedit materi ini.');
        }

        if (auth()->user()->hasRole('Admin')) {
            $undangans = Undangan::all();
        } else {
            $undangans = Undangan::where('user_id', auth()->id())->get();
        }

        return view('pages.materi.edit', compact('materi', 'undangans'));
    }

    /**
     * Update materi.
     */
    public function update(Request $request, Materi $materi)
    {
        if (!auth()->user()->hasRole('Admin') && $materi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk mengupdate materi ini.');
        }

        $request->validate([
            'undangan_id' => 'required|exists:undangan,id',
            'judul'       => 'required|string|max:255',
            'file_materi' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
        ]);

        $data = [
            'undangan_id' => $request->undangan_id,
            'judul'       => $request->judul,
        ];

        if ($request->hasFile('file_materi')) {
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $data['file_path'] = $request->file('file_materi')->store('materi', 'public');
        }

        $materi->update($data);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Hapus materi.
     */
    public function destroy(Materi $materi)
    {
        if (!auth()->user()->hasRole('Admin') && $materi->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk menghapus materi ini.');
        }

        if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
