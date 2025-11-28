<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\DTO\SurveyAnalyticsDTO;
use App\DTO\QuestionResultDTO;

class StatsController extends Controller
{
    public function index($surveyId)
    {
        // Load the survey along with its questions and related answers
        $survey = Survey::with('questions.answers')->findOrFail($surveyId);

        $questionDTOs = [];

        foreach ($survey->questions as $question) {

            // Prepare arrays for chart labels and values
            $labels = [];
            $values = [];

            // Group answers by their submitted value
            $grouped = $question->answers->groupBy('value');

            foreach ($grouped as $answerValue => $items) {
                // Each unique answer becomes a label, and the count becomes a value
                $labels[] = $answerValue;
                $values[] = $items->count();
            }

            // Create a DTO for each question to keep the data nice and clean
            $questionDTOs[] = new QuestionResultDTO(
                questionId: $question->id,
                title: $question->title,
                labels: $labels,
                values: $values
            );
        }

        // Build a high-level DTO representing all survey statistics
        $stats = new SurveyAnalyticsDTO(
            surveyId: $survey->id,
            surveyTitle: $survey->title,
            questions: $questionDTOs
        );

        // Pass everything to the Blade view
        return view('surveys.stats', compact('stats'));
    }

    public function store(Request $request)
    {
        // Nothing complicated here — just show a success message
        return redirect()->back()->with('status', 'Statistiques générées avec succès !');
    }
}
