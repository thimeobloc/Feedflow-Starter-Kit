<?php
namespace App\Actions\Survey;

use App\DTOs\SurveyDTO;
use App\DTOs\SurveyQuestionDTO;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\DB;

final class StoreSurveyQuestionAction
{
    public function __construct() {}

    /**
     * Store a Survey
     * @param SurveyQuestionDTO $dto
     * @return array
     */

    public function execute(SurveyQuestionDTO $dto): array
    {
        return DB::transaction(function () use ($dto) {
            return SurveyQuestion::create([
                'survey_id'         => 1,
                'title' => $dto->title,
                'question_type' => $dto->question_type,
                'options' => []
            ]);
        });
    }
}
