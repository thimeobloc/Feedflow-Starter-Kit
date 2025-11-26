<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganization extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        // Use the Policy to check if the user can create an organization
        return $this->user()->can('create', \App\Models\Organization::class);
    }

    /**
     * Get the validation rules that apply to the request
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'members' => 'array',
            'members.*' => 'exists:users,id',
        ];
    }
}
