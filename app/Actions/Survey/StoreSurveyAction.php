<?php
namespace App\Actions\Survey;

use App\DTOs\SurveyDTO;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

final class StoreSurveyAction
{
    public function __construct() {}

    /**
     * Exécute la logique métier de création d’un article.
     * Cette classe ne connaît ni la Request, ni le contrôleur.
     * Elle se concentre uniquement sur le "métier".
     */
    public function execute(SurveyDTO $dto): Survey
    {
        return DB::transaction(function () use ($dto) {

            $survey = Survey::create([
                'organization_id' => 1,
                'user_id'         => 1,
                'title' => $dto->title,
                'description' => $dto->description,
                'start_date' => $dto->startDate,
                'end_date' => $dto->endDate,
                'anonymous' => $dto->anonymat,
            ]);

            return [
                'survey' => $survey,
            ];
        });
    }
}
