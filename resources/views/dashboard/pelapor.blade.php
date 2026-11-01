<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelapor</title>
</head>
<body>
    <h1>Dashboard Pelapor</h1>

    <p>Selamat datang, {{ auth()->user()->name }}.</p>
    <p>Role: {{ auth()->user()->role }}</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
