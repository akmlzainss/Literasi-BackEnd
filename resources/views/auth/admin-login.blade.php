<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SIPENA</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo_sekolah.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_sekolah.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo_sekolah.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="main-container">
        <div class="auth-wrapper">
            <div class="animation-section">
                <div class="book-animation">
                    <div class="literacy-scene">
                        <div class="book-stack">
                            <div class="book"></div>
                            <div class="book"></div>
                            <div class="book"></div>
                            <div class="book"></div>
                            <div class="book"></div>
                        </div>
                        <div class="open-book">
                            <div class="book-spine"></div>
                            <div class="book-page-left"></div>
                            <div class="book-page-right"></div>
                        </div>
                        <div class="pencil"></div>
                        <div class="reading-elements">
                            <div class="floating-letter letter-1">A</div>
                            <div class="floating-letter letter-2">B</div>
                            <div class="floating-letter letter-3">C</div>
                            <div class="floating-letter letter-4">D</div>
                        </div>
                    </div>
                </div>
                <div class="welcome-text">
                    <h2>SIPENA</h2>
                    <div class="platform-badge"><i class="fas fa-user-shield me-2"></i>Admin Dashboard</div>
                </div>
            </div>

            <div class="form-section">
                <div class="logo-section">
                    <div class="logo-icon"><i class="fas fa-user-shield"></i></div>
                    <h2 class="form-title">Login Administrator</h2>
                    <p class="form-subtitle">Masuk ke panel administrasi.</p>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif
                @if ($errors->any() && !session('error'))
                    <div class="alert alert-danger mb-3">
                        Terdapat kesalahan pada input Anda. Silakan periksa kembali.
                    </div>
                @endif

                <div class="form-container active">
                    <form method="POST" action="{{ route('admin.login.submit') }}" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-group-icon"></i>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukkan email admin" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-group-icon"></i>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password admin" required>
                            </div>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary-custom mt-2"><i
                                class="fas fa-sign-in-alt me-2"></i>Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
