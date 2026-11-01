<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReportReviewController extends Controller
{

    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => [
                'nullable',
                Rule::in([
                    'menunggu_peninjauan',
                    'sedang_ditinjau',
                    'perlu_informasi_tambahan',
                    'menunggu_tindak_lanjut',
                    'selesai_diproses',
                ]),
            ],
        ]);

        $reports = Report::with([
            'user',
            'distribution.school',
            'distribution.sppg',
        ])
            ->when($validated['search'] ?? null, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($validated['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('reviews.index', compact('reports'));
    }


    public function show(int $id)
    {
        $report = Report::with([
            'user',
            'distribution.school',
            'distribution.sppg',
            'reviews.reviewer',
        ])->findOrFail($id);

        $relatedReports = Report::with('user')
            ->where('distribution_id', $report->distribution_id)
            ->where('id', '!=', $report->id)
            ->latest()
            ->get();

        $canReview = in_array($report->status, [
            'menunggu_peninjauan',
            'sedang_ditinjau',
            'perlu_informasi_tambahan',
        ]);

        return view('reviews.show', compact(
            'report',
            'relatedReports',
            'canReview'
        ));
    }

    public function store(Request $request, int $id)
    {
        $report = Report::findOrFail($id);

        if (!in_array($report->status, [
            'menunggu_peninjauan',
            'sedang_ditinjau',
            'perlu_informasi_tambahan',
        ])) {
            abort(403, 'Laporan tidak dapat diperiksa pada status ini.');
        }

        $validated = $request->validate([
            'notes' => ['required', 'string'],
            'review_status' => [
                'required',
                Rule::in([
                    'sedang_ditinjau',
                    'perlu_informasi_tambahan',
                    'menunggu_tindak_lanjut',
                ]),
            ],
        ]);

        DB::transaction(function () use ($report, $validated) {
            ReportReview::create([
                'report_id' => $report->id,
                'reviewer_id' => auth()->id(),
                'notes' => $validated['notes'],
                'review_status' => $validated['review_status'],
            ]);

            $report->update([
                'status' => $validated['review_status'],
            ]);
        });

        return redirect()
            ->route('reviews.show', $report->id)
            ->with('success', 'Pemeriksaan laporan berhasil disimpan.');
    }
}
