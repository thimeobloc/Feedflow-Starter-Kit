<?php

namespace App\DTOs;

use App\Http\Requests\Survey\StoreSurveyQuestionRequest;

final class SurveyQuestionDTO
{
    private function __construct(
        public string $title,         // Question title
        public string $question_type, // Type of question (text, choice, etc.)
        public ?array $options,       // Options only used for choice-based questions
    ) {}

    public static function fromRequest(StoreSurveyQuestionRequest $request): self
    {
        // Build the DTO directly from the validated request data
        return new self(
            title: $request->title,
            question_type: $request->question_type,
            options: $request->options ?? null,
        );
    }
}
