<?php

namespace App\DTOs;

use Illuminate\Http\Request;

final class OrganizationDTO
{
    private function __construct(
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('id', null),
            $request->input('name'),
            $request->user()->id,
            $request->input('members', [])
        );
    }

}
