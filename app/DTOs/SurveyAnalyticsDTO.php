<?php

namespace App\DTO;

class SurveyAnalyticsDTO
{
    /**
     * @param QuestionResultDTO[] $questions  List of all question stats already formatted.
     */

    public function __construct(
        public int $surveyId,      
        // ID of the survey these stats belong to

        public string $surveyTitle, 
        // Title of the survey (mainly used when displaying the charts)

        public array $questions     
        // All the processed questions, each one wrapped in its own DTO
    ) {}
}
