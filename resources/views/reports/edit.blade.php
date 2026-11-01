<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan - MBG Report</title>
</head>
<body>
    <h1>Edit Laporan</h1>

    <a href="{{ route('reports.show', $report->id) }}">
        Kembali ke Detail Laporan
    </a>

    @if ($errors->any())
        <div>
            <h3>Terjadi kesalahan:</h3>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('reports.update', $report->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="school_id">Sekolah</label>

            <select id="school_id" name="school_id" required>
                @foreach ($schools as $school)
                    <option
                        value="{{ $school->id }}"
                        {{ old('school_id', $report->distribution->school_id) == $school->id ? 'selected' : '' }}
                    >
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="distribution_id">Distribusi Makanan</label>

            <select
                id="distribution_id"
                name="distribution_id"
                data-current="{{ old('distribution_id', $report->distribution_id) }}"
                required
                disabled
            >
                <option value="">Memuat distribusi...</option>
            </select>
        </div>

        <div>
            <label for="title">Judul Laporan</label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $report->title) }}"
                required
            >
        </div>

        <div>
            <label for="incident_date">Tanggal Kejadian</label>

            <input
                type="date"
                id="incident_date"
                name="incident_date"
                value="{{ old('incident_date', $report->incident_date->format('Y-m-d')) }}"
                required
            >
        </div>

        <div>
            <label for="description">Deskripsi Kejadian</label>

            <textarea
                id="description"
                name="description"
                rows="5"
                required
            >{{ old('description', $report->description) }}</textarea>
        </div>

        <div>
            <p>
                Bukti saat ini:
                {{ $report->evidence_path ? 'Sudah tersedia' : 'Belum tersedia' }}
            </p>

            <label for="evidence">Ganti Bukti Pendukung (opsional)</label>

            <input
                type="file"
                id="evidence"
                name="evidence"
                accept=".jpg,.jpeg,.png,.pdf"
            >

            <p>Format JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.</p>
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <script>
        const schoolSelect = document.getElementById('school_id');
        const distributionSelect = document.getElementById('distribution_id');

        async function loadDistributions(selectedId = '') {
            const schoolId = schoolSelect.value;

            distributionSelect.disabled = true;
            distributionSelect.innerHTML =
                '<option value="">Memuat distribusi...</option>';

            if (!schoolId) {
                distributionSelect.innerHTML =
                    '<option value="">Pilih sekolah terlebih dahulu</option>';
                return;
            }

            try {
                const response = await fetch(
                    `{{ route('reports.distributions') }}?school_id=${schoolId}`,
                    {
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('Gagal mengambil data distribusi.');
                }

                const distributions = await response.json();

                distributionSelect.innerHTML =
                    '<option value="">Pilih Distribusi</option>';

                distributions.forEach(function (distribution) {
                    const option = document.createElement('option');

                    option.value = distribution.id;
                    option.textContent =
                        new Date(distribution.distribution_date)
                            .toLocaleDateString('id-ID');

                    if (String(distribution.id) === String(selectedId)) {
                        option.selected = true;
                    }

                    distributionSelect.appendChild(option);
                });

                if (distributions.length > 0) {
                    distributionSelect.disabled = false;
                } else {
                    distributionSelect.innerHTML =
                        '<option value="">Tidak ada distribusi tersedia</option>';
                }

            } catch (error) {
                distributionSelect.innerHTML =
                    '<option value="">Gagal memuat distribusi</option>';

                console.error(error);
            }
        }

        schoolSelect.addEventListener('change', function () {
            loadDistributions();
        });

        loadDistributions(distributionSelect.dataset.current);
    </script>
</body>
</html>
