<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ResourceDTO;
use Illuminate\Database\Eloquent\Model;

class ActivityResourceDTO extends ResourceDTO
{
    public int $id;
    public string $name;
    public ?array $parent;

    protected function defaults(): array
    {
        return [
            'parent' => self::class,
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
