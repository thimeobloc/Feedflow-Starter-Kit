<?php
namespace App\Actions\Organization;

use App\DTOs\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

final class StoreOrganizationAction
{
    public function __construct() {}

    /**
     * Store an organization
     * @param OrganizationDTO $dto
     * @return Organization
     */
    public function handle(OrganizationDTO $dto): Organization
    {
        return DB::transaction(function () use ($dto) {
            $organization = Organization::create([
                'name'    => $dto->name,
                'user_id' => $dto->owner_id,
            ]);

            $membersWithRoles = [];

            if (!empty($dto->member_ids)) {
                foreach ($dto->member_ids as $userId) {
                    if ($userId != $dto->owner_id) {
                        $membersWithRoles[$userId] = ['role' => 'Member'];
                    }
                }
            }

            $membersWithRoles[$dto->owner_id] = ['role' => 'Admin'];

            $organization->members()->sync($membersWithRoles);

            return $organization;
        });
    }
}
