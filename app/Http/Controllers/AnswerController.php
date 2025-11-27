<?php
namespace App\Http\Controllers;

use App\Actions\Survey\StoreSurveyAnswerAction;
use App\Http\Requests\Survey\StoreSurveyAnswerRequest;
use App\Models\Survey;

use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use App\Models\SurveyAnswer;
use App\DTOs\SurveyAnswerDTO;

class AnswerController extends Controller
{
    public function index(string $token)
    {
        // Récupérer le sondage via le token
        $survey = Survey::where('token', $token)->firstOrFail();

        // Récupérer les questions du sondage
        $questions = $survey->questions()->get();

        return redirect()->route('answer', ['token' => $survey->token])->with([
            'survey' => $survey,
            'questions' => $questions,
        ]);
    }

    public function store(StoreSurveyAnswerRequest $request, StoreSurveyAnswerAction $action, Survey $survey)
    {
        $dto = SurveyAnswerDTO::fromRequest($request);
        $action->execute($dto);

        return redirect()->route('answer.store', $survey->id);
    }
}