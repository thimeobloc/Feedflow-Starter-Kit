<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handles validation and authorization for updating an organization.
 */
class UpdateOrganization extends FormRequest
{
    /**
     * Determine if the user is authorized to update the organization.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $organization = $this->route('organization');

        // User must have 'update' permission on the organization
        return $organization && $this->user()->can('update', $organization);
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
            'members.*.id' => 'exists:users,id',   // Each member must exist in users table
            'members.*.role' => 'in:admin,member', // Role must be either 'admin' or 'member'
        ];
    }
}
