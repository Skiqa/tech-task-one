<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ResourceDTO;
use App\Models\Activity;
use App\Models\Building;

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
}
