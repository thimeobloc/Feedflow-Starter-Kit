<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
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
     * Message d'erreur personnalisé
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
