<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AbstractController;
use App\Models\Organization;
use App\Models\Building;
use App\Models\Activity;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\Responses\InfoOrganizationResponse;
use App\OpenApi\Responses\ListOrganizationResponse;
use App\OpenApi\SecuritySchemes\ApiKeyHeaderSecurityScheme;
use App\OpenApi\Parameters\SearchOrganizationParameters;
use App\OpenApi\Parameters\NearOrganizationParameters;

#[OpenApi\PathItem]
class OrganizationController extends AbstractController
{
    /**
     * Show the organization
     */
    #[OpenApi\Response(InfoOrganizationResponse::class)]
    #[OpenApi\SecurityRequirement(ApiKeyHeaderSecurityScheme::class)]
    #[OpenApi\Operation(tags: ['Organization'], method: 'GET')]
    public function show(Organization $organization, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getOne($organization);
        return response()->json($organizations, 200);
    }

    /**
     * Get list the organization by activity
     */
    #[OpenApi\Response(ListOrganizationResponse::class)]
    #[OpenApi\SecurityRequirement(ApiKeyHeaderSecurityScheme::class)]
    #[OpenApi\Operation(tags: ['Organization'], method: 'GET')]
    public function listOfActivity(Activity $activity, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getListOfActivity($activity);
        return response()->json($organizations, 200);
    }
    
    /**
     * Get list the organization by building
     */
    #[OpenApi\Response(ListOrganizationResponse::class)]
    #[OpenApi\SecurityRequirement(ApiKeyHeaderSecurityScheme::class)]
    #[OpenApi\Operation(tags: ['Organization'], method: 'GET')]
    public function listOfBuilding(Building $building, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getListOfBuilding($building);
        return response()->json($organizations, 200);
    }

    /**
     * Search organization by name
     */
    #[OpenApi\Response(ListOrganizationResponse::class)]
    #[OpenApi\SecurityRequirement(ApiKeyHeaderSecurityScheme::class)]
    #[OpenApi\Parameters(factory: SearchOrganizationParameters::class)]
    #[OpenApi\Operation(tags: ['Organization'], method: 'GET')]
    public function search(Request $request, OrganizationService $service): JsonResponse
    {
        $validated = $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $organizations = $service->searchByName($validated['q']);
        return response()->json($organizations, 200);
    }

    /**
     * Get list the organization by activity tree
     */
    #[OpenApi\Response(ListOrganizationResponse::class)]
    #[OpenApi\SecurityRequirement(ApiKeyHeaderSecurityScheme::class)]
    #[OpenApi\Operation(tags: ['Organization'], method: 'GET')]
    public function listByActivityTree(Activity $activity, OrganizationService $service): JsonResponse
    {
        $organizations = $service->getByActivityTree($activity);
        return response()->json($organizations, 200);
    }

    /**
     * Get list the organization by near
     */
    #[OpenApi\Response(ListOrganizationResponse::class)]
    #[OpenApi\Parameters(factory: NearOrganizationParameters::class)]
    #[OpenApi\SecurityRequirement(ApiKeyHeaderSecurityScheme::class)]
    #[OpenApi\Operation(tags: ['Organization'], method: 'GET')]
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
