<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganization extends FormRequest
{
    public function authorize(): bool
    {
        $organization = $this->route('organization');
        return $organization && $this->user()->can('update', $organization);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'members' => 'array',
            'members.*.id' => 'exists:users,id',
            'members.*.role' => 'in:Admin,Manager,Membre',
        ];
    }
}
