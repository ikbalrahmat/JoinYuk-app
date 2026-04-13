<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    public function index(Survey $survey)
    {
        // Pastikan memanggil view dengan path yang benar
        return view('pages.survey.survey_questions.index', compact('survey'));
    }

    public function store(Request $request, Survey $survey)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
        ]);

        SurveyQuestion::create([
            'survey_id' => $survey->id,
            'pertanyaan' => $request->pertanyaan,
        ]);

        return redirect()->route('survey.questions.index', $survey->id)
                         ->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    public function destroy(SurveyQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Pertanyaan berhasil dihapus');
    }

}
