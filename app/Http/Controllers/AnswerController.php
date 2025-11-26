<?php
namespace App\Http\Controllers;

use App\Models\Survey;

use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use App\Models\SurveyAnswer;
class AnswerController extends Controller
{
    public function index()
    {
        $survey = Survey::findOrFail(4);

        return view('pages.answer-modal', [
            "survey"    => $survey,
            'questions' => [ ],
        ]);
    }

    public function store(Request $request)
    {
        SurveyAnswer::create([
            'question_id' => $request->question_id,
            'answer'      => $request->answer,
        ]);

        return response()->json(['success' => 'Answer submitted successfully!']);
    }
}