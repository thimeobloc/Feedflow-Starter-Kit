<?php

namespace App\Http\Controllers;

use App\Actions\Survey\StoreSurveyQuestionAction;
use App\Actions\Survey\UpdateSurveyQuestionAction;
use App\DTOs\SurveyQuestionDTO;
use App\Http\Requests\Survey\StoreSurveyQuestionRequest;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function index(Survey $survey)
    {
        return view('pages.surveys.question', [
            "questions" => $survey->questions()->orderBy('created_at', 'desc')->get(),
            "survey" => $survey,
        ]);
    }

    public function store(StoreSurveyQuestionRequest $request, StoreSurveyQuestionAction $action, Survey $survey)
    {
        $dto = SurveyQuestionDTO::fromRequest($request);
        $action->execute($dto, $survey);
        $token = $survey->token;

        return redirect()->route('question', [
            "survey" => $survey,
            "token" => $token,
            ]);
    }

    public function update(StoreSurveyQuestionRequest $request, UpdateSurveyQuestionAction $action, Survey $survey, SurveyQuestion $question)
    {
        $dto = SurveyQuestionDTO::fromRequest($request);
        $action->execute($dto, $survey, $question);
        $token = $survey->token;

        return redirect()->route('question', [
            "token" => $token,
        ]);
    }
}
