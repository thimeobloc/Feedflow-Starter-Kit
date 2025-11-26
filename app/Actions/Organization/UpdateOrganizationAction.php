<?php

namespace App\Actions\Organization;

use App\DTOs\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

final class UpdateOrganizationAction
{
    public function handle(OrganizationDTO $dto): Organization
    {
        return DB::transaction(function () use ($dto) {
            $organization = Organization::findOrFail($dto->id);

            $organization->update([
                'name' => $dto->name,
            ]);

            if (!empty($dto->member_ids)) {
                $syncData = [];
                foreach ($dto->member_ids as $member) {
                    $syncData[$member['id']] = ['role' => $member['role']];
                }
                $organization->members()->sync($syncData);
            }

            return $organization;
        });
    }
}
