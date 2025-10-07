<?php

namespace App\Services;

use App\DTOs\OrganizationResourceDTO;
use App\DTOs\BuildingResourceDTO;
use App\DTOs\ActivityResourceDTO;
use App\Models\Organization;

class OrganizationService
{
    public function getOne(Organization $organization): OrganizationResourceDTO
    {
        $activities = $organization->activity()
            ->with(nestedRelations('parent', 3))
            ->get();

        return OrganizationResourceDTO::fromArray([
            ...$organization->toArray(),
            'activity' => $activities
                ->map(fn ($activity) => ActivityResourceDTO::fromModel($activity))
                ->toArray(),
            'building' => BuildingResourceDTO::fromModel($organization->building)->toArray(),
        ]);
    }
}
