<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - MBG Report</title>
</head>
<body>
    <h1>Detail Laporan</h1>

    <a href="{{ route('reports.index') }}">Kembali ke Daftar Laporan</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h2>{{ $report->title }}</h2>

    <p>
        Sekolah:
        {{ $report->distribution->school->name }}
    </p>

    <p>
        SPPG:
        {{ $report->distribution->sppg->name }}
    </p>

    <p>
        Tanggal Distribusi:
        {{ $report->distribution->distribution_date->format('d-m-Y') }}
    </p>

    <p>
        Tanggal Kejadian:
        {{ $report->incident_date->format('d-m-Y') }}
    </p>

    <p>
        Status:
        {{ $report->status }}
    </p>

    <p>
        Deskripsi:
        {{ $report->description }}
    </p>

    @if ($report->evidence_path)
        <p>
            Bukti pendukung:
            <a href="{{ route('reports.evidence', $report->id) }}"
            target="_blank">
                Lihat Bukti
            </a>
        </p>
    @else
        <p>
            Tidak ada bukti pendukung.
        </p>
    @endif

    @if (in_array($report->status, [
        'menunggu_peninjauan',
        'perlu_informasi_tambahan',
    ]))
        <p>
            <a href="{{ route('reports.edit', $report->id) }}">
                Edit Laporan
            </a>
        </p>
    @endif
</body>
</html>
