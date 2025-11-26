<?php

namespace App\Http\Controllers;

use App\Actions\Survey\CloseSurveyAction;
use App\Actions\Survey\StoreSurveyAction;
use App\Actions\Survey\UpdateSurveyAction;
use App\DTOs\SurveyDTO;
use App\Http\Requests\Survey\DeleteSurveyRequest;
use App\Http\Requests\Survey\StoreSurveyRequest;
use App\Http\Requests\Survey\UpdateSurveyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyController extends Controller
{
<<<<<<< HEAD
    /**
     * Affiche le formulaire d'un sondage et la liste des sondages
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Survey $survey = null)
    {
        return view('pages.survey', [
            "surveys"   => Survey::orderBy('created_at', 'desc')->get(),
            "survey"    => $survey
=======
    public function index()
    {
        $surveys = Survey::orderBy('created_at', 'desc')->get();

        return view('pages.survey', [
            "surveys" => $surveys
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
        ]);

    }

<<<<<<< HEAD
    /**
     * Enregistrer un sondage
     * @param StoreSurveyRequest $request
     * @param StoreSurveyAction $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSurveyRequest $request, StoreSurveyAction $action)
=======
    public function add(StoreSurveyRequest $request, StoreSurveyAction $action)
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
    {
        $dto = SurveyDTO::fromRequest($request);
        $action->execute($dto);

        return redirect()->route('survey');
    }

<<<<<<< HEAD
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('survey');
    }

    public function update(Survey $survey, StoreSurveyRequest $request)
    {
        $survey->update($request->only('title', 'description', 'start_date', 'end_date', 'anonymous'));
        return redirect()->route('survey');
    }


=======
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5

}
