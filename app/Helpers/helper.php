<?php

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

/**
 * Построение массива вида ['parent', 'parent.parent', 'parent.parent.parent']
 */
if (!function_exists('nestedRelations')) {
    function nestedRelations(string $relation, int $depth): array
    {
        return collect(range(1, $depth))
            ->map(fn($i) => implode('.', array_fill(0, $i, $relation)))
            ->all();
    }
}
