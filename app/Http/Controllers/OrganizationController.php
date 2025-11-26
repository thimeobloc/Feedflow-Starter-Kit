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
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    // List all organizations the user belongs to
    public function index()
    {
        $user = auth()->user();
        $organizations = $user->organizations()->withPivot('role')->get();
        return view('organizations.index', compact('organizations'));
    }

    // Show the create organization page (Blade)
    public function create()
    {
        return view('organizations.create');
    }

    // Show a single organization (JSON/API)
    public function show(Organization $organization): JsonResponse
    {
        $this->authorize('view', $organization);
        return response()->json($organization, 200);
    }

    // Create a new organization (JSON/API)
    public function store(StoreOrganization $request, StoreOrganizationAction $action)
    {
        $dto = OrganizationDTO::fromRequest($request);
        $this->authorize('create', Organization::class);

        $organization = $action->handle($dto);

        if ($request->wantsJson()) {
            return response()->json($organization, 201);
        }

        return redirect()->route('organizations.index')
                         ->with('success', 'Organisation créée avec succès !');
    }

    // Delete an organization
    public function destroy(DeleteOrganization $request, Organization $organization, DeleteOrganizationAction $action)
    {
        $this->authorize('delete', $organization);
        $action->handle($organization);

        return redirect()->route('organizations.index')
                         ->with('success', 'Organisation supprimée avec succès !');
    }
}
