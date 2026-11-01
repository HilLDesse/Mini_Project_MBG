<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pemeriksaan Laporan</title>
</head>
<body>
    <h1>Detail Pemeriksaan Laporan</h1>

    <a href="{{ route('reviews.index') }}">
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

    @if ($report->evidence_path)
        <p>
            Bukti:
            <a href="{{ route('reports.evidence', $report->id) }}"
            target="_blank">
                Lihat Bukti
            </a>
        </p>
    @else
        <p>Bukti tidak tersedia.</p>
    @endif

    <hr>

    <h2>Laporan Terkait</h2>

    @forelse ($relatedReports as $related)
        <article>
            <p>{{ $related->title }}</p>

            <p>Pelapor: {{ $related->user->name }}</p>

            <p>
                Status:
                {{ str_replace('_', ' ', $related->status) }}
            </p>
        </article>
    @empty
        <p>Tidak terdapat laporan lain pada distribusi ini.</p>
    @endforelse

    <hr>

    <h2>Riwayat Pemeriksaan</h2>

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

    @if ($canReview)
        <h2>Form Pemeriksaan</h2>

        <form
            action="{{ route('reviews.store', $report->id) }}"
            method="POST"
        >
            @csrf

            <div>
                <label for="notes">Catatan Pemeriksaan</label>
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

            <div>
                <label for="review_status">Hasil Pemeriksaan</label>
                <br>

                <select
                    name="review_status"
                    id="review_status"
                    required
                >
                    <option value="">Pilih hasil pemeriksaan</option>

                    <option
                        value="sedang_ditinjau"
                        @selected(old('review_status') === 'sedang_ditinjau')
                    >
                        Sedang Ditinjau
                    </option>

                    <option
                        value="perlu_informasi_tambahan"
                        @selected(old('review_status') === 'perlu_informasi_tambahan')
                    >
                        Perlu Informasi Tambahan
                    </option>

                    <option
                        value="menunggu_tindak_lanjut"
                        @selected(old('review_status') === 'menunggu_tindak_lanjut')
                    >
                        Menunggu Tindak Lanjut
                    </option>
                </select>

                @error('review_status')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <br>

            <button type="submit">Simpan Pemeriksaan</button>
        </form>
    @else
        <p>
            Laporan ini sudah memasuki tahap tindak lanjut atau selesai
            diproses sehingga tidak dapat diperiksa kembali.
        </p>
    @endif
</body>
</html>
