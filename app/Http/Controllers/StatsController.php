<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\DTO\SurveyAnalyticsDTO;
use App\DTO\QuestionResultDTO;

class StatsController extends Controller
{
    public function index($surveyId)
    {
        // Charge les questions + réponses du sondage
        $survey = Survey::with('questions.answers')->findOrFail($surveyId);

        $questionDTOs = [];

        foreach ($survey->questions as $question) {

            // Regroupement des réponses
            $labels = [];
            $values = [];

            $grouped = $question->answers->groupBy('value');

            foreach ($grouped as $answerValue => $items) {
                $labels[] = $answerValue;
                $values[] = $items->count();
            }

            // On crée un DTO par question
            $questionDTOs[] = new QuestionResultDTO(
                questionId: $question->id,
                title: $question->title,
                labels: $labels,
                values: $values
            );
        }

        // DTO global du sondage
        $stats = new SurveyAnalyticsDTO(
            surveyId: $survey->id,
            surveyTitle: $survey->title,
            questions: $questionDTOs
        );

        return view('surveys.stats', compact('stats'));
    }

    public function store(Request $request)
    {
        return redirect()->back()->with('status', 'Statistiques générées avec succès !');
    }
}
