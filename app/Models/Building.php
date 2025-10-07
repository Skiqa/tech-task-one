<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Model\Organization;

class Building extends Model
{
    /** @use HasFactory<\Database\Factories\BuildingFactory> */
    use HasFactory;

    protected $fillable = [
        'address',
        'lat',
        'lng',
        'created_at',
        'updated_at',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
