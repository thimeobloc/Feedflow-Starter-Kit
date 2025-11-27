<?php
namespace App\Actions\Organization;

use App\Models\Organization;
use Illuminate\Support\Facades\DB;

/**
 * Deletes an organization and detaches its members.
 */
final class DeleteOrganizationAction
{
    /**
     * Deletes the organization within a transaction.
     *
     * @param Organization $organization
     */
    public function handle(Organization $organization): void
    {
        DB::transaction(function() use ($organization) {
            $organization->members()->detach(); // Detach all members
            $organization->delete();            // Delete the organization
        });
    }
}
