<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
</head>
<body>
    <h1>Register Admin</h1>
    <form method="POST" action="{{ route('register.admin') }}">
        @csrf
        <div>
            <label>Nama Pengguna</label>
            <input type="text" name="nama_pengguna" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Register</button>
    </form>
    @if ($errors->any())
        <div>{{ $errors->first() }}</div>
    @endif
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
</body>
</html>