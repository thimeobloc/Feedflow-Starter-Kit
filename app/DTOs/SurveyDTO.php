<?php

namespace App\DTOs;

use App\Http\Requests\Survey\StoreSurveyRequest;
use App\Http\Requests\Survey\UpdateSurveyRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

final class SurveyDTO
{
    /**
     * Constructeur du DTO.
     * On y définit les données nécessaires à la création d’un article.
     */
    private function __construct(
        public string $title,
        public string $description,
        public Carbon $startDate,
        public Carbon $endDate,
        public bool   $anonymat,
    ) {}

    /**
     * Méthode statique permettant de créer le DTO à partir d'une requête validée.
     * Cela permet de centraliser la logique de transformation des données.
     */
    public static function fromRequest(StoreSurveyRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
            startDate: Carbon::parse($request->start_date),
            endDate: Carbon::parse($request->end_date),
            anonymat: (bool) $request->anonymous,
        );
    }

    /**
     * Méthode statique permettant de créer le DTO (pour update) à partir d'une requête validée.
     * Cela permet de centraliser la logique de transformation des données.
     */
    public static function fromUpdateRequest(UpdateSurveyRequest $request): self
    {
        return new self(
            title: $request->title,
            description: $request->description,
            startDate: Carbon::parse($request->start_date),
            endDate: Carbon::parse($request->end_date),
            anonymat: (bool) $request->anonymous,
        );
    }
}
