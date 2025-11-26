<?php

namespace App\DTOs;

use Illuminate\Http\Request;

final class OrganizationDTO
{
    public ?int $id;
    public string $name;
    public int $owner_id;
    public array $member_ids;

    private function __construct(?int $id, string $name, int $owner_id, array $member_ids)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->member_ids = $member_ids;
    }

    public static function fromRequest(Request $request): self
    {
        $members = $request->input('members', []);
        return new self(
            $request->input('id', null),
            $request->input('name'),
            $request->user()->id,
            $members
        );
    }
}
