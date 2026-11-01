<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'distribution_id',
        'title',
        'description',
        'incident_date',
        'status',
        'evidence_path',
    ];

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function distribution(): BelongsTo
    {
        return $this->belongsTo(Distribution::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ReportReview::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(ReportFollowUp::class);
    }
}