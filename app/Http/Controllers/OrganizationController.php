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
     * Affiche la liste des organisations de l'utilisateur
     */
    public function index()
    {
        $user = auth()->user();
        $organizations = $user->organizations()->withPivot('role')->get();

        return view('pages.organizations.index', compact('organizations'));
    }

    /**
     * Affiche le formulaire de création d'une organisation
     */
    public function create()
    {
        return view('pages.organizations.create');
    }

    /**
     * Affiche le formulaire de mise à jour d'une organisation
     */
    public function updateForm(Organization $organization)
    {
        $this->authorize('update', $organization);
        $users = \App\Models\User::all();
        $organization->load('members'); // Important pour récupérer les rôles
        $userRoles = [];
        foreach ($users as $user) {
            $member = $organization->members->firstWhere('id', $user->id);
            $userRoles[$user->id] = $member ? $member->pivot->role : null;
        }

        return view('pages.organizations.update', compact('organization', 'users', 'userRoles'));
    }

    /**
     * Enregistre une nouvelle organisation
     */
    public function store(StoreOrganization $request, StoreOrganizationAction $action)
    {
        $dto = OrganizationDTO::fromRequest($request);
        $this->authorize('create', Organization::class);
        $organization = $action->handle($dto);

        return redirect()->route('organizations.index')->with('success', 'Organisation créée avec succès !');
    }

    /**
     * Met à jour une organisation existante
     */
    public function update(UpdateOrganization $request, Organization $organization, UpdateOrganizationAction $action)
    {
        $this->authorize('update', $organization);
        $dto = OrganizationDTO::fromRequest($request);
        $action->handle($dto, $organization);

        return redirect()->route('organizations.index')->with('success', 'Organisation mise à jour avec succès !');
    }

    /**
     * Supprime une organisation
     */
    public function destroy(DeleteOrganization $request, Organization $organization, DeleteOrganizationAction $action)
    {
        $this->authorize('delete', $organization);
        $action->handle($organization);

        return redirect()->route('organizations.index')->with('success', 'Organisation supprimée avec succès !');
    }
}
