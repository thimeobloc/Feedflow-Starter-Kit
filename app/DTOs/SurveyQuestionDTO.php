<?php

namespace App\DTOs;

use App\Http\Requests\Survey\StoreSurveyQuestionRequest;

final class SurveyQuestionDTO
{
    private function __construct(
        public string $title,
        public string $question_type,
        public ?array $options,
    ) {}

    public static function fromRequest(StoreSurveyQuestionRequest $request): self
    {
        return new self(
            title: $request->title,
            question_type: $request->question_type,
            options: $request->options ?? null,
        );
    }
}
