<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Tindak Lanjut</title>
</head>
<body>
    <h1>Detail Tindak Lanjut Laporan</h1>

    <a href="{{ route('follow-ups.index') }}">
        Kembali ke Daftar Laporan
    </a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <hr>

    <h2>{{ $report->title }}</h2>

    <h3>Informasi Pelapor</h3>

    <p>Nama: {{ $report->user->name }}</p>

    <h3>Informasi Distribusi</h3>

    <p>
        Sekolah:
        {{ $report->distribution->school->name }}
    </p>

    <p>
        SPPG:
        {{ $report->distribution->sppg->name }}
    </p>

    <p>
        Tanggal distribusi:
        {{ $report->distribution->distribution_date->format('d-m-Y') }}
    </p>

    <h3>Informasi Laporan</h3>

    <p>
        Tanggal kejadian:
        {{ $report->incident_date->format('d-m-Y') }}
    </p>

    <p>
        Status:
        {{ str_replace('_', ' ', $report->status) }}
    </p>

    <p>Deskripsi:</p>

    <p>{{ $report->description }}</p>

    <p>
        Bukti:
        {{ $report->evidence_path ? 'Tersedia' : 'Tidak tersedia' }}
    </p>

    <hr>

    <h2>Riwayat Pemeriksaan Pemantau</h2>

    @forelse ($report->reviews->sortByDesc('created_at') as $review)
        <article>
            <p>
                Pemantau: {{ $review->reviewer->name }}
            </p>

            <p>
                Catatan: {{ $review->notes }}
            </p>

            <p>
                Hasil:
                {{ str_replace('_', ' ', $review->review_status) }}
            </p>

            <p>
                Waktu:
                {{ $review->created_at->format('d-m-Y H:i') }}
            </p>
        </article>

        <hr>
    @empty
        <p>Belum terdapat catatan pemeriksaan.</p>
    @endforelse

    <hr>

    <h2>Riwayat Penerusan Laporan</h2>

    @forelse ($report->followUps->sortByDesc('forwarded_at') as $followUp)
        <article>
            <p>
                Koordinator:
                {{ $followUp->coordinator->name }}
            </p>

            <p>
                Tujuan:
                {{ $followUp->destination }}
            </p>

            <p>
                Catatan:
                {{ $followUp->notes }}
            </p>

            <p>
                Waktu penerusan:
                {{ $followUp->forwarded_at->format('d-m-Y H:i') }}
            </p>
        </article>

        <hr>
    @empty
        <p>Belum terdapat catatan penerusan.</p>
    @endforelse

    <h2>Form Pencatatan Tindak Lanjut</h2>

    <form
        action="{{ route('follow-ups.store', $report->id) }}"
        method="POST"
    >
        @csrf

        <div>
            <label for="destination">Pihak Tujuan</label>
            <br>

            <input
                type="text"
                name="destination"
                id="destination"
                value="{{ old('destination') }}"
                maxlength="255"
                required
            >

            @error('destination')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="notes">Catatan Tindak Lanjut</label>
            <br>

            <textarea
                name="notes"
                id="notes"
                rows="5"
                cols="50"
                required
            >{{ old('notes') }}</textarea>

            @error('notes')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Simpan Tindak Lanjut</button>
    </form>
</body>
</html>
