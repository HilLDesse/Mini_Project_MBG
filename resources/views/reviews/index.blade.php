<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pemeriksaan Laporan</title>
</head>
<body>
    <h1>Daftar Pemeriksaan Laporan</h1>

    <p>
        Selamat datang, {{ auth()->user()->name }}.
    </p>

    <a href="{{ route('dashboard.pemantau') }}">
        Kembali ke Dashboard
    </a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <hr>

    @forelse ($reports as $report)
        <article>
            <h3>{{ $report->title }}</h3>

            <p>
                Pelapor: {{ $report->user->name }}
            </p>

            <p>
                Sekolah:
                {{ $report->distribution->school->name }}
            </p>

            <p>
                SPPG:
                {{ $report->distribution->sppg->name }}
            </p>

            <p>
                Tanggal laporan:
                {{ $report->incident_date->format('d-m-Y') }}
            </p>

            <p>
                Status: {{ str_replace('_', ' ', $report->status) }}
            </p>

            <a href="{{ route('reviews.show', $report->id) }}">
                Periksa Laporan
            </a>
        </article>

        <hr>
    @empty
        <p>Belum terdapat laporan.</p>
    @endforelse

    {{ $reports->links() }}

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
