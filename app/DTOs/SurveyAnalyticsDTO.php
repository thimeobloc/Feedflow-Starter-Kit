<?php

namespace App\DTO;

class SurveyAnalyticsDTO
{
    /**
     * @param QuestionResultDTO[] $questions
     */
    public function __construct(
        public int $surveyId,
        public string $surveyTitle,
        public array $questions
    ) {}
}
