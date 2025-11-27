<?php

namespace App\DTOs;

final class SurveyAnswerDTO
{
    private function __construct(
        public readonly int    $survey_id,
        public readonly int    $survey_question_id,
        public readonly array  $answer,
        public readonly ?int   $user_id,
    ) {}

    public static function make(
        int $survey_id,
        int $survey_question_id,
        array $answer,
        ?int $user_id
    ): self {
        return new self(
            survey_id: $survey_id,
            survey_question_id: $survey_question_id,
            answer: $answer,
            user_id: $user_id
        );
    }

    public static function fromRequest(\Illuminate\Http\Request $request): self
    {
        return new self(
            survey_id: $request->input('survey_id'),
            survey_question_id: $request->input('survey_question_id'),
            answer: (array) $request->input('answer'),
            user_id: $request->user()?->id
        );
    }
}
