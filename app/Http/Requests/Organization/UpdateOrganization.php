<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganization extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        // Get the organization from route and check if user can update it
        $organization = $this->route('organization');
        return $organization && $this->user()->can('update', $organization);
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
