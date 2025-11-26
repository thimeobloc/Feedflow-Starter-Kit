<?php

namespace App\DTOs;

use Illuminate\Http\Request;

final class SurveyAnswerDTO
{
    private function __construct(
        public readonly int    $survey_id,
        public readonly int    $question_id,
        public readonly array  $answer,
        public readonly ?int   $user_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            survey_id  : $request->input('survey_id'),
            question_id: $request->input('question_id'),
            answer     : $request->input('answer'),
            user_id    : $request->user()?->id,
        );
    }
}
