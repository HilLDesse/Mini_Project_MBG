<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Koordinator</title>
</head>
<body>
    <h1>Dashboard Koordinator</h1>

    <p>
        Selamat datang, {{ auth()->user()->name }}.
    </p>

    <p>Role: {{ auth()->user()->role }}</p>

    <hr>

    <h2>Rekapitulasi Laporan MBG</h2>

    <!-- Filter Sekolah -->
    <form action="{{ route('dashboard.koordinator') }}" method="GET">
        <label for="school_id">Filter berdasarkan sekolah:</label>

        <select name="school_id" id="school_id">
            <option value="">Semua Sekolah</option>

            @foreach ($schools as $school)
                <option
                    value="{{ $school->id }}"
                    {{ (string) $schoolId === (string) $school->id ? 'selected' : '' }}
                >
                    {{ $school->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Terapkan Filter</button>

        <a href="{{ route('dashboard.koordinator') }}">
            Reset
        </a>
    </form>

    <hr>

    <!-- Indikator -->
    <h3>Ringkasan Laporan</h3>

    <p>
        **Total Laporan:** {{ $totalReports }}
    </p>

    <p>
        **Menunggu Peninjauan:** {{ $waitingReview }}
    </p>

    <p>
        **Menunggu Tindak Lanjut:** {{ $waitingFollowUp }}
    </p>

    <hr>

    <!-- Tabel Rekapitulasi -->
    <h3>Rekapitulasi Berdasarkan Sekolah</h3>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Sekolah</th>
                <th>Total Laporan</th>
                <th>Menunggu Peninjauan</th>
                <th>Sedang Ditinjau</th>
                <th>Perlu Informasi Tambahan</th>
                <th>Menunggu Tindak Lanjut</th>
                <th>Selesai Diproses</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($recap as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total_reports }}</td>
                    <td>{{ $item->waiting_review }}</td>
                    <td>{{ $item->under_review }}</td>
                    <td>{{ $item->need_information }}</td>
                    <td>{{ $item->waiting_follow_up }}</td>
                    <td>{{ $item->completed }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data rekapitulasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    <h2>Menu Koordinator</h2>

    <a href="{{ route('follow-ups.index') }}">
        Lihat Laporan untuk Tindak Lanjut
    </a>

    <br><br>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
