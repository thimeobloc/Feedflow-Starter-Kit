<?php
namespace App\Actions\Organization;

use App\DTOs\OrganizationDTO;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

final class DeleteOrganizationAction
{
    public function __construct() {}

    /**
     * Delete an organization
     * @param OrganizationDTO $dto
     * @return bool
     */
    public function handle(OrganizationDTO $dto): bool
    {
        return DB::transaction(function () use ($dto) {
            $organization = Organization::findOrFail($dto->id);

            $organization->members()->detach();

            return $organization->delete();
        });
    }
}
