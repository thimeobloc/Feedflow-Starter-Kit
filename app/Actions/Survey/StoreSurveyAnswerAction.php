<?php

namespace App\Actions\Survey;

use App\DTOs\SurveyAnswerDTO;
use App\Models\SurveyAnswer;
use Illuminate\Support\Facades\DB;

final class StoreSurveyAnswerAction
{
    public function execute(SurveyAnswerDTO $dto): ?SurveyAnswer
    {
        $existing = SurveyAnswer::where('survey_id', $dto->survey_id)
            ->where('survey_question_id', $dto->survey_question_id)
            ->where('user_id', $dto->user_id)
            ->first();

        if ($existing) {
            return null;
        }

        return DB::transaction(function () use ($dto) {
            return SurveyAnswer::create([
                'survey_id'           => $dto->survey_id,
                'survey_question_id'  => $dto->survey_question_id,
                'user_id'             => $dto->user_id,
                'answer'              => $dto->answer,
            ]);
        });
    }
}
