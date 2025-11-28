<?php

namespace App\Http\Controllers;

use App\Actions\Survey\StoreSurveyAnswerAction;
use App\Http\Requests\Survey\StoreSurveyAnswerRequest;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\DTOs\SurveyAnswerDTO;

class AnswerController extends Controller
{
    /** Apply authentication middleware. */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Show answer form: load survey, check if user already answered, load existing answers. */
    public function index(string $token)
    {
        $survey = Survey::where('token', $token)->firstOrFail();
        $userId = auth()->id();

        $alreadyAnswered = SurveyAnswer::where('survey_id', $survey->id)
            ->where('user_id', $userId)
            ->exists();

        $existingAnswers = SurveyAnswer::where('survey_id', $survey->id)
            ->where('user_id', $userId)
            ->get()
            ->keyBy('survey_question_id');

        $questions = $survey->questions()->orderBy('created_at')->get();

        return view('pages.surveys.answer', compact('survey', 'questions', 'alreadyAnswered', 'existingAnswers'));
    }

    /** Store user answers: create DTO per question and run storage action. */
    public function store(StoreSurveyAnswerRequest $request, StoreSurveyAnswerAction $action)
    {
        $userId = auth()->id();
        $survey = Survey::findOrFail($request->survey_id);
        $answers = $request->input('answers', []);

        foreach ($answers as $surveyQuestionId => $answer) {
            $dto = SurveyAnswerDTO::make(
                survey_id: $survey->id,
                survey_question_id: (int) $surveyQuestionId,
                answer: is_array($answer) ? $answer : [$answer],
                user_id: $userId
            );

            $action->execute($dto);
        }

        return redirect()->route('answer', $survey->token)->with('success', 'Thank you for your answers!');
    }
}
