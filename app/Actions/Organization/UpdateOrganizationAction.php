<?php
namespace App\Actions\Organization;

use App\DTOs\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

final class UpdateOrganizationAction
{
    public function __construct() {}

    /**
     * Update an organization
     * @param OrganizationDTO $dto
     * @return Organization
     */
    public function handle(OrganizationDTO $dto): Organization
    {
        return DB::transaction(function () use ($dto) {
            $organization = Organization::findOrFail($dto->id);

            $organization->update([
                'name' => $dto->name,
            ]);

            if (!empty($dto->member_ids)) {
                $organization->members()->sync($dto->member_ids);
            }

            return $organization;
        });
    }
}
