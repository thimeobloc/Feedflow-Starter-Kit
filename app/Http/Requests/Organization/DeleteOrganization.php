<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class DeleteOrganization extends FormRequest
{
    public function authorize(): bool
    {
        $organization = $this->route('organization');
        return $organization && $this->user()->can('delete', $organization);
    }

    public function rules(): array
    {
        return [];
    }
}
