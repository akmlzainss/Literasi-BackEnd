<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>
    <h1>Login Admin</h1>
    <form method="POST" action="{{ route('login.admin') }}">
        @csrf
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    @if ($errors->any())
        <div>{{ $errors->first() }}</div>
    @endif

     {{-- Tombol ke Form Register Admin --}}
    <a href="{{ route('register.admin') }}">
        <button>Register Admin Baru</button>
    </a>
</body>
</html>