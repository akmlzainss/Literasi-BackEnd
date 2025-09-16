<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Literasi Akhlak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-card fade-in">
            <div class="card-header-custom">
                <h2 class="auth-title">Login</h2>
                <p class="auth-subtitle">Masuk ke Sistem Literasi Akhlak</p>
            </div>
            <div class="card-body-custom">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    {{-- Pilih Role --}}
                    <div class="mb-3">
                        <label for="role" class="form-label">Login Sebagai</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" name="email" id="email"
                                class="form-control search-input border-start-0"
                                placeholder="Masukkan email" required>
                        </div>
                        @error('email')
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                class="form-control search-input border-start-0"
                                placeholder="Masukkan password" required>
                        </div>
                        @error('password')
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">Login</button>
                </form>

                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="alert alert-danger mt-3" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
