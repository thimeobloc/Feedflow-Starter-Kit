<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handles authorization for deleting an organization.
 */
class DeleteOrganization extends FormRequest
{
    /**
     * Determine if the user is authorized to delete the organization.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $organization = $this->route('organization');

        // User must have 'delete' permission on the organization
        return $organization && $this->user()->can('delete', $organization);
    }

    /**
     * Validation rules for deleting an organization.
     * 
     * No additional input is required for deletion.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
