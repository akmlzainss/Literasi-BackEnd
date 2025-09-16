<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa</title>
</head>
<body>
    <h1>Halo, {{ Auth::guard('siswa')->user()->nama }}</h1>

    <p>Ini adalah halaman dashboard <strong>Siswa</strong>.</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
