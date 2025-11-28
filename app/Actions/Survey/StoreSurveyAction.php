<?php
namespace App\Actions\Survey;
use App\Models\User;
use Illuminate\Support\Str;
use App\DTOs\SurveyDTO;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SurveyController;

final class StoreSurveyAction
{
    public function __construct() {}

    /**
     * Exécute la logique métier de création d’un article.
     * Cette classe ne connaît ni la Request, ni le contrôleur.
     * Elle se concentre uniquement sur le "métier".
     */
    public function execute(SurveyDTO $dto, int $organization, User $user): Survey
    {
        return DB::transaction(function () use ($dto, $organization, $user) {

            return Survey::create([
                'organization_id' => $organization,
                'user_id'         =>  $user->id,
                'title' => $dto->title,
                'description' => $dto->description,
                'start_date' => $dto->startDate,
                'end_date' => $dto->endDate,
                'is_anonymous' => $dto->anonymat,
                'token' => Str::random(32),
            ]);
        });
    }
}
