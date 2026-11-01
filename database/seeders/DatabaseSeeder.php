<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\Sppg;
use App\Models\Distribution;
use App\Models\Report;
use App\Models\ReportReview;
use App\Models\ReportFollowUp;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat akun demo
        $pelapor = User::updateOrCreate(
            ['email' => 'pelapor@mbg.test'],
            [
                'name' => 'Demo Pelapor',
                'password' => 'password',
                'role' => 'pelapor',
            ]
        );

        $pemantau = User::updateOrCreate(
            ['email' => 'pemantau@mbg.test'],
            [
                'name' => 'Demo Pemantau',
                'password' => 'password',
                'role' => 'pemantau',
            ]
        );

        $koordinator = User::updateOrCreate(
            ['email' => 'koordinator@mbg.test'],
            [
                'name' => 'Demo Koordinator',
                'password' => 'password',
                'role' => 'koordinator',
            ]
        );

        // 2. Membuat data sekolah
        $schoolA = School::updateOrCreate(
            ['name' => 'SMP Harapan'],
            ['address' => 'Jl. Pendidikan No. 10']
        );

        $schoolB = School::updateOrCreate(
            ['name' => 'SD Cendekia'],
            ['address' => 'Jl. Melati No. 15']
        );

        $schoolC = School::updateOrCreate(
            ['name' => 'SMA Nusantara'],
            ['address' => 'Jl. Merdeka No. 20']
        );

        // 3. Membuat data SPPG
        $sppgA = Sppg::updateOrCreate(
            ['name' => 'SPPG Bandung Utara'],
            ['address' => 'Jl. Sukajadi No. 25']
        );

        $sppgB = Sppg::updateOrCreate(
            ['name' => 'SPPG Bandung Selatan'],
            ['address' => 'Jl. Buah Batu No. 30']
        );

        // 4. Membuat data distribusi
        $distributionA = Distribution::updateOrCreate(
            [
                'school_id' => $schoolA->id,
                'sppg_id' => $sppgA->id,
                'distribution_date' => '2026-10-20',
            ],
            []
        );

        $distributionB = Distribution::updateOrCreate(
            [
                'school_id' => $schoolB->id,
                'sppg_id' => $sppgA->id,
                'distribution_date' => '2026-10-21',
            ],
            []
        );

        $distributionC = Distribution::updateOrCreate(
            [
                'school_id' => $schoolC->id,
                'sppg_id' => $sppgB->id,
                'distribution_date' => '2026-10-22',
            ],
            []
        );

        $distributionD = Distribution::updateOrCreate(
            [
                'school_id' => $schoolA->id,
                'sppg_id' => $sppgB->id,
                'distribution_date' => '2026-10-23',
            ],
            []
        );

        $distributionE = Distribution::updateOrCreate(
            [
                'school_id' => $schoolB->id,
                'sppg_id' => $sppgB->id,
                'distribution_date' => '2026-10-24',
            ],
            []
        );

        // 5. Membuat data laporan
        $reportA = Report::updateOrCreate(
            [
                'user_id' => $pelapor->id,
                'distribution_id' => $distributionA->id,
                'title' => 'Laporan Kondisi Makanan A',
            ],
            [
                'description' => 'Terdapat informasi mengenai kondisi makanan yang perlu diperiksa lebih lanjut.',
                'incident_date' => '2026-10-20',
                'status' => 'menunggu_peninjauan',
                'evidence_path' => null,
            ]
        );

        $reportB = Report::updateOrCreate(
            [
                'user_id' => $pelapor->id,
                'distribution_id' => $distributionB->id,
                'title' => 'Laporan Kondisi Makanan B',
            ],
            [
                'description' => 'Pelapor menyampaikan adanya ketidaksesuaian kondisi makanan saat diterima.',
                'incident_date' => '2026-10-21',
                'status' => 'sedang_ditinjau',
                'evidence_path' => null,
            ]
        );

        $reportC = Report::updateOrCreate(
            [
                'user_id' => $pelapor->id,
                'distribution_id' => $distributionC->id,
                'title' => 'Laporan Kondisi Makanan C',
            ],
            [
                'description' => 'Informasi laporan membutuhkan tambahan keterangan dari pelapor.',
                'incident_date' => '2026-10-22',
                'status' => 'perlu_informasi_tambahan',
                'evidence_path' => null,
            ]
        );

        $reportD = Report::updateOrCreate(
            [
                'user_id' => $pelapor->id,
                'distribution_id' => $distributionD->id,
                'title' => 'Laporan Kondisi Makanan D',
            ],
            [
                'description' => 'Informasi laporan telah ditinjau dan diteruskan untuk tindak lanjut.',
                'incident_date' => '2026-10-23',
                'status' => 'menunggu_tindak_lanjut',
                'evidence_path' => null,
            ]
        );

        $reportE = Report::updateOrCreate(
            [
                'user_id' => $pelapor->id,
                'distribution_id' => $distributionE->id,
                'title' => 'Laporan Kondisi Makanan E',
            ],
            [
                'description' => 'Laporan telah melalui proses peninjauan dan tindak lanjut.',
                'incident_date' => '2026-10-24',
                'status' => 'selesai_diproses',
                'evidence_path' => null,
            ]
        );

        // 6. Membuat catatan peninjauan
        ReportReview::updateOrCreate(
            [
                'report_id' => $reportB->id,
                'reviewer_id' => $pemantau->id,
            ],
            [
                'notes' => 'Laporan sedang diperiksa kelengkapan informasinya.',
                'review_status' => 'sedang_ditinjau',
            ]
        );

        ReportReview::updateOrCreate(
            [
                'report_id' => $reportC->id,
                'reviewer_id' => $pemantau->id,
            ],
            [
                'notes' => 'Diperlukan informasi tambahan untuk melengkapi laporan.',
                'review_status' => 'perlu_informasi_tambahan',
            ]
        );

        ReportReview::updateOrCreate(
            [
                'report_id' => $reportD->id,
                'reviewer_id' => $pemantau->id,
            ],
            [
                'notes' => 'Informasi laporan telah diperiksa dan diteruskan.',
                'review_status' => 'menunggu_tindak_lanjut',
            ]
        );

        // 7. Membuat catatan tindak lanjut
        ReportFollowUp::updateOrCreate(
            [
                'report_id' => $reportD->id,
                'coordinator_id' => $koordinator->id,
            ],
            [
                'destination' => 'Pihak terkait',
                'notes' => 'Informasi laporan telah diteruskan untuk ditindaklanjuti.',
                'forwarded_at' => '2026-10-25 09:00:00',
            ]
        );

        ReportFollowUp::updateOrCreate(
            [
                'report_id' => $reportE->id,
                'coordinator_id' => $koordinator->id,
            ],
            [
                'destination' => 'Pihak terkait',
                'notes' => 'Tindak lanjut atas informasi laporan telah dicatat.',
                'forwarded_at' => '2026-10-26 10:00:00',
            ]
        );
    }
}
