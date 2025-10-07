<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AbstractController;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends AbstractController
{
    public function show(Organization $organization, OrganizationService $service): JsonResponse
    {
        return response()->json($service->getOne($organization), 200);
    }
}
