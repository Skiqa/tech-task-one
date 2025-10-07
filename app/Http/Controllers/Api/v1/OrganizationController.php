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
        return response()->json($service->getOne($organization), 200);
    }

    public function listOfActivity(Activity $activity, OrganizationService $service): JsonResponse
    {
        return response()->json($service->getListOfActivity($activity), 200);
    }
    
    public function listOfBuilding(Building $building, OrganizationService $service): JsonResponse
    {
        return response()->json($service->getListOfBuilding($building), 200);
    }
}
