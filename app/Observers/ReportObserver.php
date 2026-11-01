<?php

namespace App\Observers;

use App\Models\Report;
use App\Models\ReportStatusLog;
use Illuminate\Support\Facades\Auth;

class ReportObserver
{
    public function updated(Report $report): void
    {
        // Hanya mencatat jika status benar-benar berubah
        if (! $report->wasChanged('status')) {
            return;
        }

        ReportStatusLog::create([
            'report_id' => $report->id,
            'old_status' => $report->getOriginal('status'),
            'new_status' => $report->status,
            'actor_id' => Auth::id(),
            'changed_at' => now(),
        ]);
    }
}
