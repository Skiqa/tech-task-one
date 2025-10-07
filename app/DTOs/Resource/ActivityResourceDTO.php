<?php

namespace App\DTOs\Resource;

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
            'parent' => null,
        ];
    }

    protected function casts(): array
    {
        return []; 
   }
}
