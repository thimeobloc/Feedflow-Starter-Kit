<?php

namespace App\Http\Controllers;

use App\Actions\Survey\CloseSurveyAction;
use App\Actions\Survey\StoreSurveyAction;
use App\Actions\Survey\UpdateSurveyAction;
use App\DTOs\SurveyDTO;
use App\Http\Requests\Survey\StoreSurveyRequest;
use App\Http\Requests\Survey\UpdateSurveyRequest;
use App\Models\Survey;
use Illuminate\Support\Carbon;

class SurveyController extends Controller
{
    /**
     * Affiche le formulaire d'un sondage et la liste des sondages
     */
    public function index( $organizationId = null, Survey $survey = null)
    {
        $user = auth()->user();

        // Récupérer toutes les organisations de l'utilisateur
        $organizations = $user->organizations()->withPivot('role')->get();

        // Si un ID d'organisation est passé dans l'URL, récupérer cette organisation
        $organization = $organizationId ? $organizations->firstWhere('id', $organizationId) : null;

        // Récupérer les sondages, éventuellement filtrés par organisation
        $surveys = Survey::when($organizationId, function ($query, $orgId) {
            $query->where('organization_id', $orgId);
        })->orderBy('created_at', 'desc')->get();

        return view('pages.surveys.survey', [
            "organizationId" => $organizationId,
            "organization" => $organization, // organisation unique ou null
            "surveys" => $surveys,
            "survey" => $survey,
        ]);
    }

    /**
     * Enregistrer un sondage
     */
    public function store(StoreSurveyRequest $request, StoreSurveyAction $action, $organizationId)
    {
        $dto = SurveyDTO::fromRequest($request);

        // Exécuter l'action avec l'ID de l'organisation
        $action->execute($dto, (int) $organizationId, auth()->user());

        // Redirection vers la page des sondages de cette organisation
        return redirect()->route('survey', $organizationId);
    }

    /**
     * Supprimer un sondage
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();

        // Redirection vers la page de la même organisation
        return redirect()->route('survey', $survey->organization_id);
    }

    /**
     * Mettre à jour un sondage
     */
    public function update(UpdateSurveyRequest $request, UpdateSurveyAction $action, Survey $survey)
    {
        $dto = SurveyDTO::fromUpdateRequest($request);

        $action->execute($survey, $dto);

        return redirect()->route('survey', $survey->organization_id);
    }

    /**
     * Affiche le sondage public via son token
     */
    public function showPublic($token)
    {
        $survey = Survey::where('token', $token)->firstOrFail();
        $questions = $survey->questions()->orderBy('created_at', 'desc')->get();

        $now = Carbon::now();

        if ($now->lt($survey->start_date) || $now->gt($survey->end_date)) {
            abort(403, 'Ce sondage n\'est pas actif.');
        }

        return view('pages.surveys.question', compact('survey','questions', 'token'));
    }
}
