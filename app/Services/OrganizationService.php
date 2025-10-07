<?php

namespace App\Services;

use App\DTOs\OrganizationResourceDTO;
use App\DTOs\BuildingResourceDTO;
use App\DTOs\ActivityResourceDTO;
use App\Models\Organization;
use App\Models\Activity;
use App\Models\Building;
use Illuminate\Support\Collection;

class OrganizationService
{
    public function getOne(Organization $organization): OrganizationResourceDTO
    {
        $activities = $organization->activity()
            ->with(nestedRelations('parent', 3))
            ->get();

        return OrganizationResourceDTO::fromModel($organization);
    }

    public function getListOfActivity(Activity $activity): Collection
    {
        $organizations = $activity->organizations()
            ->with('activity', 'building')
            ->get();

        return $organizations->map(fn($organization) => OrganizationResourceDTO::fromModel($organization));
    }

    public function getListOfBuilding(Building $building): Collection
    {
        $organizations = $building->organizations()
            ->with('activity', 'building')
            ->get();

        return $organizations->map(fn($organization) => OrganizationResourceDTO::fromModel($organization));
    }

    public function searchByName(string $name): Collection
    {
        $organizations = Organization::query()
            ->where('name', 'ILIKE', "%{$name}%")
            ->with(['activity', 'building'])
            ->get();

        return $organizations->map(fn($organization) => OrganizationResourceDTO::fromModel($organization));
    }
}
