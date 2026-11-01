<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - MBG Report</title>
</head>
<body>
    <h1>Daftar Laporan Saya</h1>

    <p>Selamat datang, {{ auth()->user()->name }}.</p>

    <a href="{{ route('reports.create') }}">Buat Laporan</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <h2>Riwayat Laporan</h2>

    @forelse ($reports as $report)
        <article>
            <h3>{{ $report->title }}</h3>

            <p>
                Sekolah:
                {{ $report->distribution->school->name }}
            </p>

            <p>
                SPPG:
                {{ $report->distribution->sppg->name }}
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
        </article>

        <hr>
    @empty
        <p>Belum ada laporan yang dibuat.</p>
    @endforelse

    {{ $reports->links() }}

    <p>
        <a href="{{ route('dashboard.pelapor') }}">
            Kembali ke Dashboard
        </a>
    </p>
</body>
</html>
