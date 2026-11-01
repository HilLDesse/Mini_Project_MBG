<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distribution extends Model
{
    protected $fillable = [
        'school_id',
        'sppg_id',
        'distribution_date',
    ];

    protected function casts(): array
    {
        return [
            'distribution_date' => 'date',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function sppg(): BelongsTo
    {
        return $this->belongsTo(Sppg::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}