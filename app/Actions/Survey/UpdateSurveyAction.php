<?php
namespace App\Actions\Survey;

use App\DTOs\SurveyDTO;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

final class UpdateSurveyAction
{
    public function __construct() {}

    /**
     * Update a Survey
     * @param SurveyDTO $dto
     * @return array
     */
    public function execute(Survey $survey, SurveyDTO $dto): Survey
    {
        return DB::transaction(function () use ($survey, $dto) {

            $survey->update([
                'title' => $dto->title,
                'description' => $dto->description,
                'start_date' => $dto->startDate,
                'end_date' => $dto->endDate,
                'anonymous' => $dto->anonymat,
            ]);

            return $survey->fresh();
        });
    }
}
