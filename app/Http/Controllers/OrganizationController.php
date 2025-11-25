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
    public function index(): JsonResponse
    {
        $organizations = auth()->user()->organizations;
        return response()->json($organizations, 200);
    }

    // Show a single organization
    public function show(Organization $organization): JsonResponse
    {
        $this->authorize('view', $organization);
        return response()->json($organization, 200);
    }

    // Create a new organization
    public function store(StoreOrganization $request, StoreOrganizationAction $action): JsonResponse
    {
        $dto = OrganizationDTO::fromRequest($request);
        $this->authorize('create', Organization::class);
        $organization = $action->handle($dto);
        return response()->json($organization, 201);
    }

    // Update an existing organization
    public function update(UpdateOrganization $request, Organization $organization, UpdateOrganizationAction $action): JsonResponse
    {
        $dto = OrganizationDTO::fromRequest($request);
        $this->authorize('update', $organization);
        $organization = $action->handle($dto);
        return response()->json($organization, 200);
    }

    // Delete an organization
    public function destroy(DeleteOrganization $request, Organization $organization, DeleteOrganizationAction $action): JsonResponse
    {
        $this->authorize('delete', $organization);
        $action->handle(OrganizationDTO::fromRequest($request));
        return response()->json(['message' => 'Organization deleted'], 200);
    }

    // Switch the current organization
    public function switch(Organization $organization): JsonResponse
    {
        // Check if the user can view this organization
        $this->authorize('view', $organization);

        // Save the selected organization in the session
        session(['current_organization_id' => $organization->id]);

        return response()->json([
            'message' => 'Organization switched',
            'organization_id' => $organization->id
        ], 200);
    }

}
