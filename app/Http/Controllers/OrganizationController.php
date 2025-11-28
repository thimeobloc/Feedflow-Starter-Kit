<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\DTOs\OrganizationDTO;
use App\Actions\Organization\StoreOrganizationAction;
use App\Actions\Organization\UpdateOrganizationAction;
use App\Actions\Organization\DeleteOrganizationAction;
use App\Http\Requests\Organization\StoreOrganization;
use App\Http\Requests\Organization\UpdateOrganization;
use App\Http\Requests\Organization\DeleteOrganization;

class OrganizationController extends Controller
{
    /**
     * Display a list of the authenticated user's organizations.
     */
    public function index()
    {
        $user = auth()->user();
        $organizations = $user->organizations()->withPivot('role')->get();

        return view('pages.organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new organization.
     */
    public function create()
    {
        return view('pages.organizations.create');
    }

    /**
     * Show the form for updating an existing organization.
     */
    public function updateForm(Organization $organization)
    {
        $this->authorize('update', $organization);

        $users = \App\Models\User::all();
        $organization->load('members'); // Load members to access pivot roles

        $userRoles = [];
        foreach ($users as $user) {
            $member = $organization->members->firstWhere('id', $user->id);
            $userRoles[$user->id] = $member ? $member->pivot->role : null;
        }

        return view('pages.organizations.update', compact('organization', 'users', 'userRoles'));
    }

    /**
     * Store a newly created organization.
     */
    public function store(StoreOrganization $request, StoreOrganizationAction $action)
    {
        $this->authorize('create', Organization::class);

        $dto = OrganizationDTO::fromRequest($request);
        $organization = $action->handle($dto);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization created successfully!');
    }

    /**
     * Update an existing organization.
     */
    public function update(UpdateOrganization $request, Organization $organization, UpdateOrganizationAction $action)
    {
        $this->authorize('update', $organization);

        $dto = OrganizationDTO::fromRequest($request);
        $action->handle($dto, $organization);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization updated successfully!');
    }

    /**
     * Delete an organization.
     */
    public function destroy(DeleteOrganization $request, Organization $organization, DeleteOrganizationAction $action)
    {
        $this->authorize('delete', $organization);

        $action->handle($organization);

        return redirect()->route('organizations.index')
            ->with('success', 'Organization deleted successfully!');
    }
}
