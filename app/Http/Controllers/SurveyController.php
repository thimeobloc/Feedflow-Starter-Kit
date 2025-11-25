<?php

namespace App\Http\Controllers;

use App\Actions\Survey\StoreSurveyAction;
use App\DTOs\SurveyDTO;
use App\Http\Requests\Survey\StoreSurveyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function add(StoreSurveyRequest $request) :JsonResponse
    {
        $dto    = SurveyDTO::fromRequest($request);
        $result = app(StoreSurveyAction::class)->execute($dto);

        return response()->json([
            'message' => 'Sondage créé avec succès.',
            'result' => $result,
        ]);
    }
}
