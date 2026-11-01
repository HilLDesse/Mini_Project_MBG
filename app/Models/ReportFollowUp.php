<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportFollowUp extends Model
{
    protected $fillable = [
        'report_id',
        'coordinator_id',
        'destination',
        'notes',
        'forwarded_at',
    ];

    protected function casts(): array
    {
        return [
            'forwarded_at' => 'datetime',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }
}