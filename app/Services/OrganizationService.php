<?php

namespace App\Services;

use App\DTOs\Resource\OrganizationResourceDTO;
use App\DTOs\Resource\BuildingResourceDTO;
use App\DTOs\Resource\ActivityResourceDTO;
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

    public function getByActivityTree(Activity $activity): Collection
    {
        $activityIds = collect($this->flattenActivities($activity))->pluck('id');
        $organizations = Organization::query()
            ->whereIn('activity_id', $activityIds)
            ->with(['activity', 'building'])
            ->get();

        return $organizations->map(fn($organization) => OrganizationResourceDTO::fromModel($organization));
    }

    private function flattenActivities(Activity $activity): array
    {
        return array_merge(
            [$activity],
            ...$activity->childrenRecursive->map(fn($child) => $this->flattenActivities($child))
        );
    }

    public function getNearby(float $lat, float $lng, float $radius)
    {
        $haversine = "(6371 * acos(cos(radians(?)) 
                    * cos(radians(lat)) 
                    * cos(radians(lng) - radians(?)) 
                    + sin(radians(?)) 
                    * sin(radians(lat))))";

        return Organization::with(['activity', 'building'])
            ->whereHas('building', function ($query) use ($lat, $lng, $radius, $haversine) {
                $query->whereRaw("$haversine <= ?", [$lat, $lng, $lat, $radius]);
            })->get();
    }
}
