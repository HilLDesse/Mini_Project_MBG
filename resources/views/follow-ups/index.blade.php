<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tindak Lanjut</title>
</head>
<body>
    <h1>Daftar Laporan untuk Tindak Lanjut</h1>

    <p>
        Selamat datang, {{ auth()->user()->name }}.
    </p>

    <a href="{{ route('dashboard.koordinator') }}">
        Kembali ke Dashboard
    </a>

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
                Tanggal kejadian:
                {{ $report->incident_date->format('d-m-Y') }}
            </p>

            <p>
                Status:
                {{ str_replace('_', ' ', $report->status) }}
            </p>

            <a href="{{ route('follow-ups.show', $report->id) }}">
                Lihat Detail dan Catat Tindak Lanjut
            </a>
        </article>

        <hr>
    @empty
        <p>
            Belum terdapat laporan yang menunggu tindak lanjut.
        </p>
    @endforelse

    {{ $reports->links() }}

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
