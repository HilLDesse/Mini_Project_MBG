<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Koordinator</title>
</head>
<body>
    <h1>Dashboard Koordinator</h1>

    <p>
        Selamat datang, {{ auth()->user()->name }}.
    </p>

    <p>Role: {{ auth()->user()->role }}</p>

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
