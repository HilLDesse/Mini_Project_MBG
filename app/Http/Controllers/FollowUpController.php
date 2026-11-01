<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportFollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowUpController extends Controller
{
    public function index()
    {
        $reports = Report::with([
            'user',
            'distribution.school',
            'distribution.sppg',
        ])
            ->where('status', 'menunggu_tindak_lanjut')
            ->latest()
            ->paginate(10);

        return view('follow-ups.index', compact('reports'));
    }

    public function show(int $id)
    {
        $report = Report::with([
            'user',
            'distribution.school',
            'distribution.sppg',
            'reviews.reviewer',
            'followUps.coordinator',
        ])
            ->where('status', 'menunggu_tindak_lanjut')
            ->findOrFail($id);

        return view('follow-ups.show', compact('report'));
    }

    public function store(Request $request, int $id)
    {
        $report = Report::where(
            'status',
            'menunggu_tindak_lanjut'
        )->findOrFail($id);

        $validated = $request->validate([
            'destination' => ['required', 'string', 'max:255'],
            'notes' => ['required', 'string'],
        ]);

        DB::transaction(function () use ($report, $validated) {
            ReportFollowUp::create([
                'report_id' => $report->id,
                'coordinator_id' => auth()->id(),
                'destination' => $validated['destination'],
                'notes' => $validated['notes'],
                'forwarded_at' => now(),
            ]);
        });

        return redirect()
            ->route('follow-ups.show', $report->id)
            ->with('success', 'Pencatatan tindak lanjut berhasil disimpan.');
    }
}
