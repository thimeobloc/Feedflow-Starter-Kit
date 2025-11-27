<?php

namespace App\DTOs;

use Illuminate\Http\Request;

/**
 * Data Transfer Object for organization data.
 */
final class OrganizationDTO
{
    public ?int $id;
    public string $name;
    public int $owner_id;
    public array $member_ids;

    /**
     * Private constructor to enforce creation via fromRequest.
     */
    private function __construct(?int $id, string $name, int $owner_id, array $member_ids)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->member_ids = $member_ids;
    }

    /**
     * Create a DTO instance from an HTTP request.
     *
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $members = $request->input('members', []);

        return new self(
            $request->input('id', null),
            $request->input('name'),
            $request->user()->id, // Owner is the authenticated user
            $members
        );
    }
}
