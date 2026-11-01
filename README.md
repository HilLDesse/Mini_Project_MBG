# MBG Report

Aplikasi Pelaporan dan Pemantauan Keamanan Makanan pada Program Makan Bergizi Gratis (MBG).

## Deskripsi Proyek

MBG Report merupakan aplikasi berbasis web yang dikembangkan untuk mendukung proses pelaporan, pemeriksaan, dan pencatatan tindak lanjut laporan terkait keamanan makanan pada program Makan Bergizi Gratis (MBG).

Aplikasi ini memiliki tiga jenis pengguna, yaitu Pelapor, Pemantau Komunitas, dan Koordinator Komunitas. Setiap pengguna memiliki hak akses dan tanggung jawab yang berbeda sesuai dengan perannya.

## Fitur Aplikasi

### 1. Pelapor
- Login dan logout.
- Membuat laporan terkait keamanan makanan.
- Mengunggah bukti pendukung laporan.
- Melihat daftar dan detail laporan miliknya.
- Mengedit laporan berdasarkan ketentuan status.
- Melihat perkembangan status laporan.

### 2. Pemantau Komunitas
- Melihat daftar laporan yang perlu diperiksa.
- Melakukan pencarian dan filter laporan.
- Melihat detail laporan dan bukti pendukung.
- Memberikan catatan pemeriksaan.
- Menentukan hasil pemeriksaan sesuai pilihan status yang tersedia.

### 3. Koordinator Komunitas
- Melihat daftar laporan yang menunggu tindak lanjut.
- Melakukan pencarian laporan.
- Melihat detail laporan dan bukti pendukung.
- Mencatat pihak tujuan penerusan laporan.
- Mencatat informasi tindak lanjut.
- Melihat ringkasan dan rekapitulasi laporan berdasarkan sekolah.

### 4. Fitur Umum
- Autentikasi pengguna.
- Pembatasan hak akses berdasarkan role.
- Validasi data pada proses pengelolaan laporan.
- Penyimpanan bukti laporan menggunakan Laravel Storage.
- Pencarian, filter, dan pagination.
- Pengambilan data distribusi berdasarkan sekolah menggunakan JavaScript Fetch API.
- Pencatatan perubahan status laporan menggunakan Eloquent Observer.
- Dashboard ringkasan laporan.

## Teknologi yang Digunakan

- PHP 8.3 atau lebih baru.
- Laravel 13.
- MySQL.
- HTML.
- JavaScript.
- Composer.
- Node.js dan NPM.

## Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:

- PHP 8.3 atau lebih baru.
- Composer.
- MySQL.
- Node.js dan NPM.
- Git.

## Instalasi dan Konfigurasi

### 1. Clone Repository

```bash
git clone https://github.com/HilLDesse/Mini_Project_MBG.git
```

### 2. Masuk ke Direktori Proyek

```bash
cd Mini_Project_MBG
```

### 3. Instal Dependensi PHP

```bash
composer install
```

### 4. Salin File Environment

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buat database MySQL dengan nama:

```text
mbg_report
```

### 7. Konfigurasi Database

Sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mbg_report
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password dengan konfigurasi MySQL yang digunakan.

### 8. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

Perintah tersebut digunakan untuk membuat tabel database dan mengisi data awal aplikasi.

### 9. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi dapat diakses melalui alamat:

```text
http://127.0.0.1:8000
```

## Akun Demo

Aplikasi menyediakan akun demo untuk pengujian berdasarkan masing-masing role.

| Role | Email | Password |
|---|---|---|
| Pelapor | pelapor@mbg.test | password |
| Pemantau Komunitas | pemantau@mbg.test | password |
| Koordinator Komunitas | koordinator@mbg.test | password |

## Struktur Database

Aplikasi menggunakan beberapa tabel utama:

| Tabel | Keterangan |
|---|---|
| users | Menyimpan data pengguna dan role |
| schools | Menyimpan data sekolah |
| sppgs | Menyimpan data SPPG |
| distributions | Menyimpan data distribusi makanan |
| reports | Menyimpan data laporan |
| report_reviews | Menyimpan catatan pemeriksaan laporan |
| report_follow_ups | Menyimpan catatan tindak lanjut |
| report_status_logs | Menyimpan riwayat perubahan status laporan |

## Penyimpanan Bukti Laporan

Bukti pendukung laporan disimpan menggunakan Laravel Storage pada penyimpanan lokal.

Format file yang diperbolehkan:
- JPG
- JPEG
- PNG
- PDF

Ukuran maksimal file adalah 2 MB.

Akses bukti laporan dilakukan melalui route aplikasi dengan pemeriksaan hak akses pengguna.

## Catatan

- File `.env` berisi konfigurasi lokal dan tidak disertakan dalam repository.
- File `.env.example` digunakan sebagai contoh konfigurasi lingkungan aplikasi.
- Akun demo digunakan untuk kebutuhan pengujian aplikasi.
