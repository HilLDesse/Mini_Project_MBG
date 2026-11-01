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

    <h2>Pencarian dan Filter</h2>

    <form action="{{ route('reviews.index') }}" method="GET">
        <div>
            <label for="search">Cari Judul Laporan</label>
            <br>

            <input
                type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                placeholder="Masukkan judul laporan"
            >
        </div>

        <br>

        <div>
            <label for="status">Filter Status</label>
            <br>

            <select name="status" id="status">
                <option value="">Semua Status</option>

                <option
                    value="menunggu_peninjauan"
                    @selected(request('status') === 'menunggu_peninjauan')
                >
                    Menunggu Peninjauan
                </option>

                <option
                    value="sedang_ditinjau"
                    @selected(request('status') === 'sedang_ditinjau')
                >
                    Sedang Ditinjau
                </option>

                <option
                    value="perlu_informasi_tambahan"
                    @selected(request('status') === 'perlu_informasi_tambahan')
                >
                    Perlu Informasi Tambahan
                </option>

                <option
                    value="menunggu_tindak_lanjut"
                    @selected(request('status') === 'menunggu_tindak_lanjut')
                >
                    Menunggu Tindak Lanjut
                </option>

                <option
                    value="selesai_diproses"
                    @selected(request('status') === 'selesai_diproses')
                >
                    Selesai Diproses
                </option>
            </select>
        </div>

        <br>

        <button type="submit">Terapkan</button>

        <a href="{{ route('reviews.index') }}">
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
                Tanggal laporan:
                {{ $report->incident_date->format('d-m-Y') }}
            </p>

            <p>
                Status:
                {{ str_replace('_', ' ', $report->status) }}
            </p>

            <a href="{{ route('reviews.show', $report->id) }}">
                Periksa Laporan
            </a>
        </article>

        <hr>
    @empty
        <p>Tidak ditemukan laporan yang sesuai.</p>
    @endforelse

    {{ $reports->links() }}

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
