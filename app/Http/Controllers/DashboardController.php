<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function coordinator(Request $request)
    {
        $validated = $request->validate([
            'school_id' => ['nullable', 'integer', 'exists:schools,id'],
        ]);

        $schoolId = $validated['school_id'] ?? null;

        // Mengambil daftar sekolah untuk filter
        $schools = School::orderBy('name')->get();

        // Query dasar laporan berdasarkan sekolah
        $reportsQuery = Report::query()
            ->whereHas('distribution', function ($query) use ($schoolId) {
                if ($schoolId) {
                    $query->where('school_id', $schoolId);
                }
            });

        // Menghitung indikator
        $totalReports = (clone $reportsQuery)->count();

        $waitingReview = (clone $reportsQuery)
            ->where('status', 'menunggu_peninjauan')
            ->count();

        $waitingFollowUp = (clone $reportsQuery)
            ->where('status', 'menunggu_tindak_lanjut')
            ->count();

        // Mengambil rekap laporan berdasarkan sekolah
        $recap = DB::table('schools')
            ->leftJoin('distributions', 'schools.id', '=', 'distributions.school_id')
            ->leftJoin('reports', 'distributions.id', '=', 'reports.distribution_id')
            ->select('schools.id', 'schools.name')
            ->selectRaw('COUNT(reports.id) AS total_reports')
            ->selectRaw(
                "SUM(CASE WHEN reports.status = 'menunggu_peninjauan' THEN 1 ELSE 0 END) AS waiting_review"
            )
            ->selectRaw(
                "SUM(CASE WHEN reports.status = 'sedang_ditinjau' THEN 1 ELSE 0 END) AS under_review"
            )
            ->selectRaw(
                "SUM(CASE WHEN reports.status = 'perlu_informasi_tambahan' THEN 1 ELSE 0 END) AS need_information"
            )
            ->selectRaw(
                "SUM(CASE WHEN reports.status = 'menunggu_tindak_lanjut' THEN 1 ELSE 0 END) AS waiting_follow_up"
            )
            ->selectRaw(
                "SUM(CASE WHEN reports.status = 'selesai_diproses' THEN 1 ELSE 0 END) AS completed"
            )
            ->when($schoolId, function ($query) use ($schoolId) {
                $query->where('schools.id', $schoolId);
            })
            ->groupBy('schools.id', 'schools.name')
            ->orderBy('schools.name')
            ->get();

        return view('dashboard.koordinator', compact(
            'schools',
            'schoolId',
            'totalReports',
            'waitingReview',
            'waitingFollowUp',
            'recap'
        ));
    }
}
