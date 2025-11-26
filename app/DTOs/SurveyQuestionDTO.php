<?php

namespace App\DTOs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Survey\StoreSurveyQuestionRequest;
final class SurveyQuestionDTO
{
    private function __construct(
        public string $title,
        public string $question_type,
    ) {}

    public static function fromRequest(StoreSurveyQuestionRequest $request): self
    {
        return new self(
                title: $request->title,
                question_type: $request->question_type,
            );
    }
}

