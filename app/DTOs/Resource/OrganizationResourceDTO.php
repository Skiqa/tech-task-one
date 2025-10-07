<?php

namespace App\DTOs\Resource;

use WendellAdriel\ValidatedDTO\ResourceDTO;
use App\Models\Activity;
use App\Models\Building;
use Illuminate\Database\Eloquent\Model;

class OrganizationResourceDTO extends ResourceDTO
{
    public string $name;
    public ?int $number;
    public ?string $created_at;
    public ?string $updated_at;
    public ?array $activity;
    public ?array $building;

    protected function defaults(): array
    {
        return [
            'activity' => 'array'
        ];
    }

    protected function casts(): array
    {
        return [];
    }

    
    public static function fromModel(Model $model): static
    {
        $activities = $model->activity()
            ->with(nestedRelations('parent', 3))
            ->get();

        return OrganizationResourceDTO::fromArray([
            ...$model->toArray(),
            'activity' => $activities
                ->map(fn ($activity) => ActivityResourceDTO::fromModel($activity))
                ->toArray(),
            'building' => BuildingResourceDTO::fromModel($model->building)->toArray(),
        ]);
    }
}
