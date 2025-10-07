<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AbstractController;
use App\Models\Organization;
use App\Models\Building;
use App\Models\Activity;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends AbstractController
{
    public function show(Organization $organization, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getOne($organization);
        return response()->json($organizations, 200);
    }

    public function listOfActivity(Activity $activity, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getListOfActivity($activity);
        return response()->json($organizations, 200);
    }
    
    public function listOfBuilding(Building $building, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getListOfBuilding($building);
        return response()->json($organizations, 200);
    }

    public function search(Request $request, OrganizationService $service): JsonResponse
    {
        $validated = $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $organizations = $service->searchByName($validated['q']);
        return response()->json(organizations, 200);
    }

    public function listByActivityTree(Activity $activity, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getByActivityTree($activity);
        return response()->json($organizations, 200);
    }

    public function nearby(Request $request, OrganizationService $service): JsonResponse
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'nullable|numeric|min:0',
        ]);

        $organizations = $service->getNearby($validated['lat'], $validated['lng'], $validated['radius']);
        return response()->json($organizations, 200);
    }
}
