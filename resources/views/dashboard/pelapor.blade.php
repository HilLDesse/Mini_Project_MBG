
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelapor</title>
</head>
<body>
    <h1>Dashboard Pelapor</h1>

    <p>Selamat datang, {{ auth()->user()->name }}.</p>
    <p>Role: {{ auth()->user()->role }}</p>

    <h2>Menu Pelaporan</h2>

    <ul>
        <li>
            <a href="{{ route('reports.index') }}">
                Daftar Laporan Saya
            </a>
        </li>
        <li>
            <a href="{{ route('reports.create') }}">
                Buat Laporan Baru
            </a>
        </li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
