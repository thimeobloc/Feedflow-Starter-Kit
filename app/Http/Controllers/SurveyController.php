<?php

namespace App\Http\Controllers;

use App\Actions\Survey\CloseSurveyAction;
use App\Actions\Survey\StoreSurveyAction;
use App\Actions\Survey\UpdateSurveyAction;
use App\DTOs\SurveyDTO;
use App\Http\Requests\Survey\StoreSurveyRequest;
use App\Http\Requests\Survey\UpdateSurveyRequest;
use App\Http\Requests\Survey\DeleteSurveyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyController extends Controller
{
    /**
     * Affiche le formulaire d'un sondage et la liste des sondages
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Survey $survey = null)
    {
        return view('pages.survey', [
            "surveys"   => Survey::orderBy('created_at', 'desc')->get(),
            "survey"    => $survey,
        ]);
    }

    /**
     * Enregistrer un sondage
     * @param StoreSurveyRequest $request
     * @param StoreSurveyAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSurveyRequest $request, StoreSurveyAction $action)
    {
        $dto = SurveyDTO::fromRequest($request);
        $action->execute($dto);

        return redirect()->route('survey');
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('survey');
    }

    public function update(UpdateSurveyRequest $request, UpdateSurveyAction $action, Survey $survey)
    {
        $dto = SurveyDTO::fromUpdateRequest($request);
        $action->execute($survey, $dto);

        return redirect()->route('survey');
    }

}
