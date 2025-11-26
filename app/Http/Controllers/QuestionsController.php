<?php

namespace App\Http\Controllers;

use App\Actions\Survey\StoreSurveyQuestionAction;
use App\DTOs\SurveyQuestionDTO;
use App\Http\Requests\Survey\StoreSurveyQuestionRequest;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index(Survey $survey)
    {
        return view('pages.question', [
            "questions" => $survey->questions()->orderBy('created_at', 'desc')->get(),
            "survey" => $survey,
        ]);
    }

    public function store(StoreSurveyQuestionRequest $request, StoreSurveyQuestionAction $action)
    {
        $dto = SurveyQuestionDTO::fromRequest($request);
        $action->execute($dto);

        return redirect()->route('survey');
    }
}
