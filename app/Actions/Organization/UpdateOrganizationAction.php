<?php

namespace App\Actions\Organization;

use App\DTOs\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

/**
 * Action to update an organization and manage its members and roles.
 */
final class UpdateOrganizationAction
{
    /**
     * Update the organization name and sync members with roles within a transaction.
     *
     * @param OrganizationDTO $dto
     * @param Organization $organization
     * @return Organization
     */
    public function handle(OrganizationDTO $dto, Organization $organization): Organization
    {
        return DB::transaction(function () use ($dto, $organization) {

            // Update organization name
            $organization->update([
                'name' => $dto->name,
            ]);

            // Extract member IDs from DTO
            $checkedIds = collect($dto->member_ids ?? [])
                ->pluck('id')
                ->filter()
                ->toArray();

            // Ensure the owner remains attached
            if (!in_array($organization->user_id, $checkedIds)) {
                $checkedIds[] = $organization->user_id;
            }

            // Attach or update members with roles
            foreach ($dto->member_ids ?? [] as $member) {
                if (isset($member['id'], $member['role'])) {
                    $orgUser = $organization->members()->where('user_id', $member['id'])->first();
                    if ($orgUser) {
                        $organization->members()->updateExistingPivot($member['id'], [
                            'role' => $member['role']
                        ]);
                    } else {
                        $organization->members()->attach($member['id'], [
                            'role' => $member['role']
                        ]);
                    }
                }
            }

            // Detach members not in the updated list
            $currentIds = $organization->members()->pluck('user_id')->toArray();
            $toDetach = array_diff($currentIds, $checkedIds);
            if (!empty($toDetach)) {
                $organization->members()->detach($toDetach);
            }

            return $organization;
        });
    }
}
