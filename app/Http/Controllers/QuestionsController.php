<?php

namespace App\Http\Controllers;

use App\Models\Survey;

use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index(Survey $survey)
    {
        return view('pages.question', [
            "survey"    => $survey,
        ]);
    }

    public function store(Request $request, Survey $survey)
    {
        $options = null;

        if ($request->type === 'radio' || $request->type === 'checkbox') {
            $options = array_filter($request->options);
        }

        if ($request->type === 'scale') {
            $options = [
                'min' => 1,
                'max' => 10
            ];
        }

        $survey->questions()->create([
            'title'         => $request->title,
            'question_type' => $request->type,
            'options'       => $options,
        ]);

        return back()->with('Succes', 'Question added successfully!');
    }
}
