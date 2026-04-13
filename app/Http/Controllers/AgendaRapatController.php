<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapat;
use App\Models\AgendaRapat;
use App\Models\Undangan;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendaRapatController extends Controller
{
    // ===== CRUD Rapat =====

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $search = $request->input('search');

        $query = Rapat::orderBy('tanggal', 'desc')
            ->when($search, function ($q) use ($search) {
                $q->where('nama_rapat', 'like', '%' . $search . '%');
            });

        // ✅ kalau bukan admin, filter hanya rapat milik user login
        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        $rapat = $query->paginate($perPage)
            ->appends(['search' => $search, 'per_page' => $perPage]);

        return view('pages.agenda.index', compact('rapat', 'search', 'perPage'));
    }

public function create()
{
    // kalau admin -> lihat semua undangan
    if (auth()->user()->hasRole('admin')) {
        $undangan = Undangan::orderBy('tanggal', 'desc')->get();
    } else {
        // kalau bukan admin -> cuma lihat undangan miliknya
        $undangan = Undangan::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    return view('pages.agenda.create', compact('undangan'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'undangan_id' => 'required|exists:undangan,id',
        'nama_rapat'  => 'required|string|max:255',
        'tanggal'     => 'required|date',
        'tempat'      => 'required|string|max:255',
        'pic_rapat'   => 'required|string|max:255',
        'catatan'     => 'nullable|string',
    ]);

    // proteksi biar user gak bisa pakai undangan orang lain
    if (!auth()->user()->hasRole('admin')) {
        $undangan = Undangan::where('id', $request->undangan_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$undangan) {
            abort(403, 'Anda tidak punya akses untuk undangan ini.');
        }
    }

    Rapat::create([
        'user_id'    => auth()->id(),
        'nama_rapat' => $validatedData['nama_rapat'],
        'tanggal'    => $validatedData['tanggal'],
        'tempat'     => $validatedData['tempat'],
        'pic_rapat'  => $validatedData['pic_rapat'],
        'catatan'    => $validatedData['catatan'] ?? null,
    ]);

    return redirect()->route('agenda.index')->with('success', 'Rapat berhasil ditambahkan!');
}

    public function show($id)
    {
        $rapat = Rapat::with('agendaRapat')->findOrFail($id);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses ke agenda ini.');
        }

        return view('pages.agenda.show', compact('rapat'));
    }

    public function edit($id)
    {
        $rapat = Rapat::findOrFail($id);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk edit rapat ini.');
        }

        return view('pages.agenda.edit', compact('rapat'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_rapat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tempat' => 'required|string|max:255',
            'pic_rapat' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $rapat = Rapat::findOrFail($id);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk update rapat ini.');
        }

        $rapat->update($validatedData);

        return redirect()->route('agenda.index')->with('success', 'Rapat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $rapat = Rapat::findOrFail($id);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk hapus rapat ini.');
        }

        $rapat->delete();

        return redirect()->route('agenda.index')->with('success', 'Rapat berhasil dihapus!');
    }

    public function exportPdf($rapatId)
    {
        $rapat = Rapat::with('agendaRapat')->findOrFail($rapatId);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses untuk export agenda ini.');
        }

        $pdf = Pdf::loadView('pages.agenda.pdf', compact('rapat'));
        return $pdf->download("agenda-rapat-{$rapatId}.pdf");
    }

    // ===== CRUD Item Agenda (agenda_rapats) =====
    public function agendaCreate($rapatId)
    {
        $rapat = Rapat::findOrFail($rapatId);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses.');
        }

        return view('pages.agenda.agenda_create', compact('rapat'));
    }

    public function agendaStore(Request $request, $rapatId)
    {
        $rapat = Rapat::findOrFail($rapatId);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses.');
        }

        $request->validate([
            'jam' => 'required|string|max:20',
            'agenda' => 'required|string',
            'pic' => 'required|string|max:255',
        ]);

        AgendaRapat::create([
            'rapat_id' => $rapatId,
            'jam' => $request->jam,
            'agenda' => $request->agenda,
            'pic' => $request->pic,
        ]);

        return redirect()->route('agenda.show', $rapatId)->with('success', 'Item agenda berhasil ditambahkan!');
    }

    public function agendaEdit($rapatId, $agendaId)
    {
        $rapat = Rapat::findOrFail($rapatId);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses.');
        }

        $agenda = AgendaRapat::findOrFail($agendaId);
        return view('pages.agenda.agenda_edit', compact('rapat', 'agenda'));
    }

    public function agendaUpdate(Request $request, $rapatId, $agendaId)
    {
        $rapat = Rapat::findOrFail($rapatId);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses.');
        }

        $request->validate([
            'jam' => 'required|string|max:20',
            'agenda' => 'required|string',
            'pic' => 'required|string|max:255',
        ]);

        $agenda = AgendaRapat::findOrFail($agendaId);
        $agenda->update([
            'jam' => $request->jam,
            'agenda' => $request->agenda,
            'pic' => $request->pic,
        ]);

        return redirect()->route('agenda.show', $rapatId)->with('success', 'Item agenda berhasil diupdate!');
    }

    public function agendaDestroy($rapatId, $agendaId)
    {
        $rapat = Rapat::findOrFail($rapatId);

        // ✅ proteksi akses
        if (!auth()->user()->hasRole('admin') && $rapat->user_id !== auth()->id()) {
            abort(403, 'Anda tidak punya akses.');
        }

        $agenda = AgendaRapat::findOrFail($agendaId);
        $agenda->delete();

        return redirect()->route('agenda.show', $rapatId)->with('success', 'Item agenda berhasil dihapus!');
    }
}
