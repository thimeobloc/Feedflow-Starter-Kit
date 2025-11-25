<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class DeleteOrganization extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        // Get the organization from route and check if user can delete it
        $organization = $this->route('organization');
        return $organization && $this->user()->can('delete', $organization);
    }

    /**
     * Get the validation rules that apply to the request
     */
    public function rules(): array
    {
        // No additional fields needed for deletion
        return [];
    }
}
