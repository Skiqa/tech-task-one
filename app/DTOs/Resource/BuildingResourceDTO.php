<?php

namespace App\DTOs\Resource;

use WendellAdriel\ValidatedDTO\ResourceDTO;

class BuildingResourceDTO extends ResourceDTO
{
    public int $id;
    public string $address;
    public string $lat;
    public string $lng;

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
