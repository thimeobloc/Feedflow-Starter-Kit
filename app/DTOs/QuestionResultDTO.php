<?php

namespace App\DTO;

class QuestionResultDTO
{
    public function __construct(
        public int $questionId,
        public string $title,
        public array $labels,
        public array $values
    ) {}
}
