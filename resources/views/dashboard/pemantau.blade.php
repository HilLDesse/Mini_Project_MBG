<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pemantau</title>
</head>
<body>
    <h1>Dashboard Pemantau</h1>

    <p>Selamat datang, {{ auth()->user()->name }}.</p>
    <p>Role: {{ auth()->user()->role }}</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
