<?php
namespace App\Actions\Survey;

use App\DTOs\SurveyDTO;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;

final class CloseSurveyAction
{
    public function __construct() {}

    /**
     * Store a Survey
     * @param SurveyDTO $dto
     * @return array
     */
    public function execute(SurveyDTO $dto): Survey
    {
        return DB::transaction(function () use ($dto) {

        });
    }
}
