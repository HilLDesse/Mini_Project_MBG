<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sppg extends Model
{
    protected $fillable = [
        'name',
        'address',
    ];

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class);
    }
}