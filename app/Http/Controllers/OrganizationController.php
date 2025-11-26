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
    public function index()
    {
        $user = auth()->user();
        $organizations = $user->organizations()->withPivot('role')->get();
        return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function updateForm(Organization $organization)
    {
        $this->authorize('update', $organization);
        $users = \App\Models\User::all();
        $organization->load('members'); // Important pour récupérer les rôles
        return view('organizations.update', compact('organization', 'users'));
    }

    public function store(StoreOrganization $request, StoreOrganizationAction $action)
    {
        $dto = OrganizationDTO::fromRequest($request);
        $this->authorize('create', Organization::class);
        $organization = $action->handle($dto);
        return redirect()->route('organizations.index')->with('success', 'Organisation créée avec succès !');
    }

    public function update(UpdateOrganization $request, Organization $organization, UpdateOrganizationAction $action)
    {
        $this->authorize('update', $organization);
        $dto = OrganizationDTO::fromRequest($request);
        $action->handle($dto, $organization);
        return redirect()->route('organizations.index')->with('success', 'Organisation mise à jour avec succès !');
    }

    public function destroy(DeleteOrganization $request, Organization $organization, DeleteOrganizationAction $action)
    {
        $this->authorize('delete', $organization);
        $action->handle($organization);
        return redirect()->route('organizations.index')->with('success', 'Organisation supprimée avec succès !');
    }
}
