<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handles validation and authorization for creating a new organization.
 */
class StoreOrganization extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Check using the policy if the user can create an organization
        return $this->user()->can('create', \App\Models\Organization::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'members' => 'array',
            'members.*' => 'exists:users,id', // Ensure each member exists in users table
        ];
    }
}
