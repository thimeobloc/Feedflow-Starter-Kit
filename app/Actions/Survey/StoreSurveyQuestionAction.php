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

    public function execute(SurveyQuestionDTO $dto, $survey)
    {
        return DB::transaction(function () use ($dto, $survey) {
            return SurveyQuestion::create([
                'survey_id'         => $survey->id,
                'title' => $dto->title,
                'question_type' => $dto->question_type,
                'options' => $dto->options ?? [],
            ]);
        });
    }
}
