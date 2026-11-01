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

    <h2>Pencarian Laporan</h2>

    <form action="{{ route('follow-ups.index') }}" method="GET">
        <label for="search">Cari Judul Laporan</label>
        <br>

        <input
            type="text"
            name="search"
            id="search"
            value="{{ request('search') }}"
            placeholder="Masukkan judul laporan"
        >

        <button type="submit">Cari</button>

        <a href="{{ route('follow-ups.index') }}">
            Reset
        </a>
    </form>

    <hr>

    <h2>Hasil Laporan</h2>

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
            Tidak ditemukan laporan yang menunggu tindak lanjut.
        </p>
    @endforelse

    {{ $reports->links() }}

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
