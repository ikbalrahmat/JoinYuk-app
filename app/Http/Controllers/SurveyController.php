<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        // hanya tampilkan survey milik user login
        $surveys = Survey::where('user_id', Auth::id())
            ->withCount('questions')
            ->withCount([
                'responses as respondents_count' => function ($query) {
                    $query->select(DB::raw('COUNT(DISTINCT COALESCE(user_id, anon_id))'));
                }
            ])
            ->get();

        return view('pages.survey.index', compact('surveys'));
    }

    public function create()
    {
        return view('pages.survey.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Draft,Aktif,Selesai',
        ]);

        Survey::create([
            'judul' => $request->judul,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('survey.index')->with('success', 'Survey berhasil dibuat');
    }

    public function edit(Survey $survey)
    {
        // pastikan hanya pemilik survey yang bisa edit
        if ($survey->user_id !== Auth::id()) {
            abort(403, 'Tidak boleh mengedit survey orang lain');
        }

        return view('pages.survey.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        // pastikan hanya pemilik survey yang bisa update
        if ($survey->user_id !== Auth::id()) {
            abort(403, 'Tidak boleh mengupdate survey orang lain');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Draft,Aktif,Selesai',
        ]);

        $survey->update([
            'judul' => $request->judul,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return redirect()->route('survey.index')->with('success', 'Survey berhasil diupdate');
    }

    public function destroy(Survey $survey)
    {
        // pastikan hanya pemilik survey yang bisa hapus
        if ($survey->user_id !== Auth::id()) {
            abort(403, 'Tidak boleh menghapus survey orang lain');
        }

        $survey->delete();
        return redirect()->route('survey.index')->with('success', 'Survey berhasil dihapus');
    }
}
