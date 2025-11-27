<?php

namespace App\Actions\Organization;

use App\DTOs\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

final class UpdateOrganizationAction
{
    public function handle(OrganizationDTO $dto, Organization $organization): Organization
    {
        return DB::transaction(function () use ($dto, $organization) {

            $organization->update([
                'name' => $dto->name,
            ]);

            $checkedIds = collect($dto->member_ids ?? [])
                ->pluck('id')
                ->filter()
                ->toArray();

            // Assure que l’owner reste toujours attaché
            if (!in_array($organization->user_id, $checkedIds)) {
                $checkedIds[] = $organization->user_id;
            }
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
            $currentIds = $organization->members()->pluck('user_id')->toArray();
            $toDetach = array_diff($currentIds, $checkedIds);
            if (!empty($toDetach)) {
                $organization->members()->detach($toDetach);
            }

            return $organization;
        });
    }
}
