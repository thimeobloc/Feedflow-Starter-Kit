<?php
namespace App\Actions\Organization;

use App\DTOs\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

/**
 * Action to create a new organization and assign members with roles.
 */
final class StoreOrganizationAction
{
    public function __construct() {}

    /**
     * Create an organization and attach members with roles within a transaction.
     *
     * @param OrganizationDTO $dto
     * @return Organization
     */
    public function handle(OrganizationDTO $dto): Organization
    {
        return DB::transaction(function () use ($dto) {
            // Create the organization
            $organization = Organization::create([
                'name'    => $dto->name,
                'user_id' => $dto->owner_id,
            ]);

            // Prepare members with their roles
            $membersWithRoles = [];

            if (!empty($dto->member_ids)) {
                foreach ($dto->member_ids as $userId) {
                    if ($userId != $dto->owner_id) {
                        $membersWithRoles[$userId] = ['role' => 'Member'];
                    }
                }
            }

            // Ensure the owner is assigned as Admin
            $membersWithRoles[$dto->owner_id] = ['role' => 'Admin'];

            // Sync members with roles
            $organization->members()->sync($membersWithRoles);

            return $organization;
        });
    }
}
