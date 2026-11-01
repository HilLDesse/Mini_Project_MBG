<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ReportEvidenceController extends Controller
{
    public function show(int $id)
    {
        $user = auth()->user();

        $report = Report::findOrFail($id);

        // Pelapor hanya boleh mengakses bukti miliknya sendiri.
        if (
            $user->role === 'pelapor'
            && $report->user_id !== $user->id
        ) {
            abort(403);
        }

        // Pemantau hanya boleh mengakses laporan
        // yang tersedia dalam proses pemeriksaan.
        if (
            $user->role === 'pemantau'
            && !in_array($report->status, [
                'menunggu_peninjauan',
                'sedang_ditinjau',
                'perlu_informasi_tambahan',
            ])
        ) {
            abort(403);
        }

        // Koordinator hanya boleh mengakses laporan
        // yang sedang menunggu tindak lanjut.
        if (
            $user->role === 'koordinator'
            && $report->status !== 'menunggu_tindak_lanjut'
        ) {
            abort(403);
        }

        // Pastikan laporan memiliki bukti.
        if (!$report->evidence_path) {
            abort(404, 'Bukti laporan tidak tersedia.');
        }

        $disk = Storage::disk('local');

        // Pastikan file benar-benar tersedia.
        if (!$disk->exists($report->evidence_path)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        // Tampilkan file di browser.
        return response()->file(
            $disk->path($report->evidence_path)
        );
    }
}
