<?php

namespace App\Actions\Survey;

use App\DTOs\SurveyQuestionDTO;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\DB;

final class UpdateSurveyQuestionAction
{
    public function __construct() {}

    public function execute(SurveyQuestionDTO $dto, $survey, $question): SurveyQuestion
    {
        return DB::transaction(function () use ($dto, $survey, $question) {

            $question->update([
                'survey_id'     => $survey->id,
                'title'         => $dto->title,
                'question_type' => $dto->question_type,
                'options'       => $dto->options,
            ]);

            return $question->fresh();
        });
    }
}
