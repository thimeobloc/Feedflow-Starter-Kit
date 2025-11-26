<?php
namespace App\Actions\Survey;

use App\DTOs\SurveyDTO;
use App\DTOs\SurveyAnswerDTO;
use App\Models\SurveyAnswer;
use Illuminate\Support\Facades\DB;

final class StoreSurveyAnswerAction
{
    public function execute (SurveyAnswerDTO $dto): SurveyAnswer {
        return DB::transaction(function () use ($dto) {
            return SurveyAnswer::create([
                'survey_id'   => $dto->survey_id,
                'question_id' => $dto->question_id,
                'answer'      => $dto->answer,
                'user_id'     => $dto->user_id,
            ]);
    }
        );
    }
}