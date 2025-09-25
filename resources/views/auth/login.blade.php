<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register - SIPENA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="main-container">
        <div class="auth-wrapper">
            <div class="animation-section">
                <div class="book-animation">
                    <div class="literacy-scene">
                        <div class="book-stack">
                            <div class="book"></div><div class="book"></div><div class="book"></div><div class="book"></div><div class="book"></div>
                        </div>
                        <div class="open-book">
                            <div class="book-spine"></div><div class="book-page-left"></div><div class="book-page-right"></div>
                        </div>
                        <div class="pencil"></div>
                        <div class="reading-elements">
                            <div class="floating-letter letter-1">A</div><div class="floating-letter letter-2">B</div><div class="floating-letter letter-3">C</div><div class="floating-letter letter-4">D</div>
                        </div>
                    </div>
                </div>
                <div class="welcome-text">
                    <h2>SIPENA</h2>
                    <div class="platform-badge"><i class="fas fa-book-reader me-2"></i>Platform Literasi Digital</div>
                </div>
            </div>

            <div class="form-section">
                <div class="logo-section">
                    <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
                    <h2 class="form-title">Selamat Datang</h2>
                    <p class="form-subtitle">Masuk atau daftar untuk memulai.</p>
                </div>

                <div class="auth-tabs">
                    <button class="auth-tab active" onclick="switchTab('login', this)">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                    <button class="auth-tab" onclick="switchTab('register', this)">
                        <i class="fas fa-user-plus me-2"></i>Daftar (Khusus Siswa)
                    </button>
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

                <div id="loginForm" class="form-container active">
                    <form method="POST" action="{{ route('login.submit') }}" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-group-icon"></i>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                            </div>
                            @error('email')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-group-icon"></i>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password Anda" required>
                            </div>
                            @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary-custom mt-2"><i class="fas fa-sign-in-alt me-2"></i>Masuk</button>
                    </form>
                </div>

                <div id="registerForm" class="form-container">
                    <form method="POST" action="{{ route('register.submit') }}" novalidate>
                        @csrf
                        <input type="hidden" name="role" value="siswa">

                        <div class="form-group">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <i class="fas fa-user input-group-icon"></i>
                                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap" required value="{{ old('nama') }}">
                            </div>
                            @error('nama')<div class="text-danger mt-1">{{ $message }}</div>@endif
                        </div>

                        <div class="form-group">
                            <label for="nis" class="form-label">Nomor Induk Siswa (NIS)</label>
                            <div class="input-group">
                                <i class="fas fa-id-card input-group-icon"></i>
                                <input type="text" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" placeholder="Masukkan NIS Anda" required value="{{ old('nis') }}">
                            </div>
                            @error('nis')<div class="text-danger mt-1">{{ $message }}</div>@endif
                        </div>

                        <div class="form-group">
                            <label for="reg_kelas" class="form-label">Kelas</label>
                            <div class="input-group">
                                <i class="fas fa-school input-group-icon"></i>
                                <input type="text" name="kelas" id="reg_kelas" class="form-control @error('kelas') is-invalid @enderror" placeholder="Masukkan kelas Anda (misal: X IPA 1)" required value="{{ old('kelas') }}">
                            </div>
                            @error('kelas')<div class="text-danger mt-1">{{ $message }}</div>@endif
                        </div>

                        <div class="form-group">
                            <label for="reg_email" class="form-label">Email</label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-group-icon"></i>
                                <input type="email" name="email" id="reg_email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
                            </div>
                            @error('email')<div class="text-danger mt-1">{{ $message }}</div>@endif
                        </div>

                        <div class="row-cols-2">
                            <div class="form-group">
                                <label for="reg_password" class="form-label">Password</label>
                                <div class="input-group">
                                    <i class="fas fa-lock input-group-icon"></i>
                                    <input type="password" name="password" id="reg_password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                                </div>
                                @error('password')<div class="text-danger mt-1">{{ $message }}</div>@endif
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <i class="fas fa-lock input-group-icon"></i>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">Saya menyetujui <a href="#">Syarat & Ketentuan</a></label>
                        </div>
                        @error('terms')<div class="text-danger mt-1">{{ $message }}</div>@endif

                        <button type="submit" class="btn btn-primary-custom mt-2"><i class="fas fa-user-plus me-2"></i>Daftar Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab, element) {
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.form-container').forEach(f => f.classList.remove('active'));
            element.classList.add('active');
            document.getElementById(tab + 'Form').classList.add('active');
        }
    </script>
</body>
</html>