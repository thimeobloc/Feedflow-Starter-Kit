<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur peut s'authentifier
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'anonymous' => 'required|boolean',
        ];
    }

    /**
     * Personnalize error message
     */
    public function messages(): array{
        return [
            'title.required' => 'Le titre est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'start_date.required' => 'La date de debut est obligatoire.',
            'end_date.required' => 'La date de fin est obligatoire.',
            'anonymous.required' => 'Le champ anonymat est obligatoire.',
        ];
    }
}
