<?php
namespace App\Actions\Organization;

use App\Models\Organization;
use Illuminate\Support\Facades\DB;

final class DeleteOrganizationAction
{
    public function handle(Organization $organization)
    {
        DB::transaction(function() use ($organization) {
            $organization->members()->detach();
            $organization->delete();
        });
    }
}
