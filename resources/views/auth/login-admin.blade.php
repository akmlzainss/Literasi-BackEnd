<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPENA </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #4682b4 100%);
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="books" x="0" y="0" width="25" height="25" patternUnits="userSpaceOnUse"><rect width="3" height="18" x="3" y="3" fill="rgba(255,255,255,0.08)" rx="1"/><rect width="3" height="15" x="8" y="5" fill="rgba(255,255,255,0.06)" rx="1"/><rect width="3" height="17" x="13" y="4" fill="rgba(255,255,255,0.04)" rx="1"/><circle cx="20" cy="12" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="20" fill="url(%23books)"/></svg>') repeat;
            opacity: 0.4;
            z-index: 1;
        }

        .main-container {
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1100px;
            width: 100%;
            height: 80vh;
            max-height: 700px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(30, 60, 114, 0.4);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animation-section {
            padding: 30px 25px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #4682b4 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .animation-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.15) 0%, transparent 50%);
        }

        .book-animation {
            width: 280px;
            height: 280px;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .literacy-scene {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animated Book Stack */
        .book-stack {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: floatBooks 4s ease-in-out infinite;
        }

        @keyframes floatBooks {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .book {
            width: 60px;
            height: 8px;
            margin: 2px 0;
            border-radius: 2px;
            position: relative;
            transform-origin: center;
        }

        .book:nth-child(1) {
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            animation: bookWiggle1 3s ease-in-out infinite;
        }

        .book:nth-child(2) {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            animation: bookWiggle2 3s ease-in-out infinite 0.5s;
        }

        .book:nth-child(3) {
            background: linear-gradient(135deg, #45b7d1, #96c93d);
            animation: bookWiggle3 3s ease-in-out infinite 1s;
        }

        .book:nth-child(4) {
            background: linear-gradient(135deg, #f9ca24, #f0932b);
            animation: bookWiggle4 3s ease-in-out infinite 1.5s;
        }

        .book:nth-child(5) {
            background: linear-gradient(135deg, #a55eea, #8e44ad);
            animation: bookWiggle5 3s ease-in-out infinite 2s;
        }

        @keyframes bookWiggle1 {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(2deg) scale(1.05); }
            75% { transform: rotate(-1deg) scale(0.98); }
        }

        @keyframes bookWiggle2 {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(-2deg) scale(1.02); }
            75% { transform: rotate(1deg) scale(1.03); }
        }

        @keyframes bookWiggle3 {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(1deg) scale(0.98); }
            75% { transform: rotate(-2deg) scale(1.05); }
        }

        @keyframes bookWiggle4 {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(-1deg) scale(1.03); }
            75% { transform: rotate(2deg) scale(0.97); }
        }

        @keyframes bookWiggle5 {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(2deg) scale(0.99); }
            75% { transform: rotate(-1deg) scale(1.04); }
        }

        /* Open Book Animation */
        .open-book {
            position: absolute;
            top: -50px;
            right: -30px;
            width: 80px;
            height: 60px;
            animation: bookFloat 3s ease-in-out infinite;
        }

        @keyframes bookFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(5deg); }
        }

        .book-page-left, .book-page-right {
            position: absolute;
            width: 35px;
            height: 50px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 3px;
            top: 5px;
        }

        .book-page-left {
            left: 5px;
            transform: rotateY(-20deg);
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }

        .book-page-right {
            right: 5px;
            transform: rotateY(20deg);
            box-shadow: -2px 2px 8px rgba(0,0,0,0.1);
        }

        .book-spine {
            position: absolute;
            width: 8px;
            height: 60px;
            background: linear-gradient(135deg, #1e3c72, #4682b4);
            left: 50%;
            transform: translateX(-50%);
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(30, 60, 114, 0.3);
        }

        /* Reading Elements */
        .reading-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .floating-letter {
            position: absolute;
            font-size: 24px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            animation: floatLetter 6s ease-in-out infinite;
        }

        .letter-1 { top: 20%; left: 10%; animation-delay: 0s; }
        .letter-2 { top: 30%; right: 15%; animation-delay: 1s; }
        .letter-3 { bottom: 25%; left: 20%; animation-delay: 2s; }
        .letter-4 { bottom: 35%; right: 10%; animation-delay: 3s; }

        @keyframes floatLetter {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
                opacity: 0.3; 
            }
            50% { 
                transform: translateY(-20px) rotate(10deg); 
                opacity: 0.7; 
            }
        }

        /* Pencil Animation */
        .pencil {
            position: absolute;
            bottom: 10px;
            left: 20px;
            width: 4px;
            height: 60px;
            background: linear-gradient(to bottom, #f39c12, #e67e22, #2c3e50);
            border-radius: 2px;
            transform-origin: bottom;
            animation: pencilWrite 4s ease-in-out infinite;
        }

        @keyframes pencilWrite {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            75% { transform: rotate(-10deg); }
        }

        .pencil::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 8px solid #2c3e50;
        }

        /* Platform Text Enhancement */
        .platform-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-top: 15px;
            display: inline-block;
            animation: badgeGlow 3s ease-in-out infinite;
        }

        @keyframes badgeGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.2); }
            50% { box-shadow: 0 0 30px rgba(255, 255, 255, 0.4); }
        }

        .welcome-text {
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
        }

        .welcome-text h2 {
            font-size: 2.1rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .welcome-text p {
            font-size: 1rem;
            opacity: 0.95;
            line-height: 1.6;
            font-weight: 400;
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .form-section {
            padding: 30px 25px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            overflow-y: auto;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1e3c72 0%, #4682b4 100%);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.35);
            transition: transform 0.3s ease;
        }

        .logo-icon:hover {
            transform: translateY(-3px);
        }

        .logo-icon i {
            color: white;
            font-size: 28px;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 400;
        }

        .auth-tabs {
            display: flex;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 25px;
            border: 2px solid #e9ecef;
        }

        .auth-tab {
            flex: 1;
            padding: 10px 18px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            color: #6c757d;
            border: none;
            background: transparent;
        }

        .auth-tab.active {
            background: #1e3c72;
            color: white;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            font-weight: 600;
            color: #1e3c72;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .form-select, .form-control {
            border: 2px solid #e3f2fd;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fbff;
            font-family: 'Poppins', sans-serif;
        }

        .form-select:focus, .form-control:focus {
            border-color: #2a5298;
            box-shadow: 0 0 0 0.25rem rgba(42, 82, 152, 0.15);
            background: white;
            outline: none;
        }

        .input-group-text {
            background: #f8fbff;
            border: 2px solid #e3f2fd;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #4682b4;
            padding: 12px 18px;
        }

        .form-control.border-start-0 {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: #2a5298;
            background: white;
        }

        .form-check {
            margin: 15px 0;
        }

        .form-check-input {
            border-radius: 6px;
            border: 2px solid #e3f2fd;
        }

        .form-check-input:checked {
            background-color: #2a5298;
            border-color: #2a5298;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(42, 82, 152, 0.15);
            border-color: #2a5298;
        }

        .form-check-label {
            font-weight: 500;
            color: #1e3c72;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #1e3c72 0%, #4682b4 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.3);
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(30, 60, 114, 0.4);
            background: linear-gradient(135deg, #2a5298 0%, #5a9bd4 100%);
        }

        .btn-primary-custom:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            font-weight: 500;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
        }

        .text-danger {
            color: #ff6b6b;
            font-weight: 500;
        }

        .row-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .main-container {
                height: 100vh;
                padding: 15px;
            }
            
            .auth-wrapper {
                grid-template-columns: 1fr;
                max-width: 100%;
                height: 95vh;
                max-height: none;
            }

            .animation-section {
                padding: 20px 15px;
                height: auto;
                min-height: 40vh;
            }

            .book-animation {
                width: 180px;
                height: 180px;
                margin-bottom: 15px;
            }

            .welcome-text h2 {
                font-size: 1.6rem;
                margin-bottom: 10px;
            }

            .welcome-text p {
                font-size: 0.9rem;
                line-height: 1.5;
            }

            .form-section {
                padding: 20px 15px;
                height: auto;
                min-height: 55vh;
            }

            .form-title {
                font-size: 1.7rem;
            }

            .logo-section {
                margin-bottom: 20px;
            }

            .auth-tabs {
                margin-bottom: 20px;
            }

            .row-cols {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-group {
                margin-bottom: 16px;
            }
            
            .platform-badge {
                font-size: 0.8rem;
                padding: 6px 12px;
                margin-top: 8px;
            }

            .logo-icon {
                width: 55px;
                height: 55px;
                margin-bottom: 15px;
            }

            .logo-icon i {
                font-size: 26px;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 10px;
            }
            
            .auth-wrapper {
                border-radius: 20px;
                height: 98vh;
            }
            
            .animation-section {
                padding: 15px 10px;
                min-height: 35vh;
            }
            
            .book-animation {
                width: 150px;
                height: 150px;
                margin-bottom: 10px;
            }
            
            .welcome-text h2 {
                font-size: 1.4rem;
            }
            
            .welcome-text p {
                font-size: 0.85rem;
            }
            
            .form-section {
                padding: 15px 10px;
                min-height: 60vh;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
            
            .logo-icon {
                width: 50px;
                height: 50px;
            }
            
            .logo-icon i {
                font-size: 24px;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .auth-tab {
                padding: 8px 14px;
                font-size: 0.9rem;
            }

            .form-select, .form-control {
                padding: 10px 14px;
                font-size: 0.9rem;
            }

            .input-group-text {
                padding: 10px 14px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="auth-wrapper">
            <!-- Animation Section -->
            <div class="animation-section">
                <div class="book-animation">
                    <div class="literacy-scene">
                        <!-- Book Stack Animation -->
                        <div class="book-stack">
                            <div class="book"></div>
                            <div class="book"></div>
                            <div class="book"></div>
                            <div class="book"></div>
                            <div class="book"></div>
                        </div>
                        
                        <!-- Open Book -->
                        <div class="open-book">
                            <div class="book-spine"></div>
                            <div class="book-page-left"></div>
                            <div class="book-page-right"></div>
                        </div>
                        
                        <!-- Pencil -->
                        <div class="pencil"></div>
                        
                        <!-- Floating Letters -->
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
                    <div class="platform-badge">
                        <i class="fas fa-book-reader me-2"></i>Platform Literasi Digital
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <div class="logo-section">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h2 class="form-title">Selamat Datang</h2>
                    <p class="form-subtitle">Silakan masuk atau daftar untuk melanjutkan</p>
                </div>

                <!-- Auth Tabs -->
                <div class="auth-tabs">
                    <button class="auth-tab active" onclick="switchTab('login')">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                    <button class="auth-tab" onclick="switchTab('register')">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                </div>

                <!-- Login Form -->
                <div id="loginForm" class="form-container active">
                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label for="role" class="form-label">Login Sebagai</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @error('role')
                                <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control border-start-0" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control border-start-0" placeholder="Masukkan password Anda" required>
                            </div>
                            @error('password')
                                <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary-custom"><i class="fas fa-sign-in-alt me-2"></i>Masuk</button>
                    </form>
                    @if ($errors->any() && !$errors->has('role') && !$errors->has('email') && !$errors->has('password'))
                        <div class="alert alert-danger mt-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif
                </div>

                <!-- Register Form -->
                <div id="registerForm" class="form-container">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="reg_role" class="form-label">Daftar Sebagai</label>
                            <select name="role" id="reg_role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>
                        <div class="row-cols">
                            <div class="form-group">
                                <label for="first_name" class="form-label">Nama Depan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="first_name" id="first_name" class="form-control border-start-0" placeholder="Nama depan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label">Nama Belakang</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="last_name" id="last_name" class="form-control border-start-0" placeholder="Nama belakang" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reg_email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" id="reg_email" class="form-control border-start-0" placeholder="Masukkan email Anda" required>
                            </div>
                        </div>
                        <div class="row-cols">
                            <div class="form-group">
                                <label for="reg_password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="reg_password" class="form-control border-start-0" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0" placeholder="Konfirmasi password" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">Saya menyetujui <a href="#" style="color: #2a5298; font-weight: 600;">Syarat & Ketentuan</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary-custom"><i class="fas fa-user-plus me-2"></i>Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.form-container').forEach(f => f.classList.remove('active'));
            event.target.classList.add('active');
            if (tab === 'login') {
                document.getElementById('loginForm').classList.add('active');
            } else {
                document.getElementById('registerForm').classList.add('active');
            }
        }

        // Button loading animation
        document.querySelectorAll('.btn-primary-custom').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fas fa-spinner fa-spin me-2';
                setTimeout(() => { icon.className = originalClass; }, 2000);
            });
        });

        // Enhanced book animation with more interactive elements
        function createFloatingElements() {
            const scene = document.querySelector('.literacy-scene');
            
            // Create floating words periodically
            setInterval(() => {
                const words = ['Read', 'Write', 'Learn', 'Grow', 'Inspire'];
                const word = words[Math.floor(Math.random() * words.length)];
                
                const floatingWord = document.createElement('div');
                floatingWord.textContent = word;
                floatingWord.style.cssText = `
                    position: absolute;
                    font-size: 12px;
                    color: rgba(255, 255, 255, 0.4);
                    font-weight: 600;
                    pointer-events: none;
                    animation: wordFloat 4s ease-out forwards;
                    left: ${Math.random() * 80 + 10}%;
                    top: ${Math.random() * 80 + 10}%;
                `;
                
                scene.appendChild(floatingWord);
                
                // Remove after animation
                setTimeout(() => {
                    if (floatingWord.parentNode) {
                        floatingWord.parentNode.removeChild(floatingWord);
                    }
                }, 4000);
            }, 3000);
        }

        // Add floating word animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes wordFloat {
                0% { 
                    opacity: 0; 
                    transform: translateY(20px) scale(0.8); 
                }
                50% { 
                    opacity: 1; 
                    transform: translateY(-10px) scale(1); 
                }
                100% { 
                    opacity: 0; 
                    transform: translateY(-40px) scale(0.6); 
                }
            }
        `;
        document.head.appendChild(style);

        // Initialize floating elements
        createFloatingElements();

        // Add interactive hover effects to book stack
        document.querySelector('.book-stack').addEventListener('mouseenter', function() {
            this.style.animationDuration = '2s';
        });

        document.querySelector('.book-stack').addEventListener('mouseleave', function() {
            this.style.animationDuration = '4s';
        });

        // Parallax effect for better depth
        document.addEventListener('mousemove', function(e) {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            const bookStack = document.querySelector('.book-stack');
            const openBook = document.querySelector('.open-book');
            const pencil = document.querySelector('.pencil');
            
            if (bookStack) {
                bookStack.style.transform = `translate(${mouseX * 10 - 5}px, ${mouseY * 10 - 5}px)`;
            }
            
            if (openBook) {
                openBook.style.transform = `translate(${mouseX * -8}px, ${mouseY * -8}px)`;
            }
            
            if (pencil) {
                pencil.style.transform = `translate(${mouseX * 6}px, ${mouseY * 6}px) rotate(${mouseX * 5}deg)`;
            }
        });

        // Add page turning effect
        function addPageTurnEffect() {
            const leftPage = document.querySelector('.book-page-left');
            const rightPage = document.querySelector('.book-page-right');
            
            setInterval(() => {
                if (Math.random() > 0.7) {
                    leftPage.style.animation = 'pageTurn 1.5s ease-in-out';
                    setTimeout(() => {
                        leftPage.style.animation = '';
                    }, 1500);
                }
            }, 5000);
        }

        // Add page turn animation
        const pageTurnStyle = document.createElement('style');
        pageTurnStyle.textContent = `
            @keyframes pageTurn {
                0% { transform: rotateY(-20deg); }
                50% { transform: rotateY(20deg) scale(1.1); }
                100% { transform: rotateY(-20deg); }
            }
        `;
        document.head.appendChild(pageTurnStyle);

        addPageTurnEffect();

        // Add sparkle effects around books
        function createSparkles() {
            const scene = document.querySelector('.literacy-scene');
            
            setInterval(() => {
                for (let i = 0; i < 3; i++) {
                    const sparkle = document.createElement('div');
                    sparkle.innerHTML = '✨';
                    sparkle.style.cssText = `
                        position: absolute;
                        font-size: ${Math.random() * 8 + 8}px;
                        color: rgba(255, 255, 255, 0.6);
                        pointer-events: none;
                        animation: sparkleFloat 3s ease-out forwards;
                        left: ${Math.random() * 100}%;
                        top: ${Math.random() * 100}%;
                    `;
                    
                    scene.appendChild(sparkle);
                    
                    setTimeout(() => {
                        if (sparkle.parentNode) {
                            sparkle.parentNode.removeChild(sparkle);
                        }
                    }, 3000);
                }
            }, 4000);
        }

        // Add sparkle animation
        const sparkleStyle = document.createElement('style');
        sparkleStyle.textContent = `
            @keyframes sparkleFloat {
                0% { 
                    opacity: 0; 
                    transform: translateY(0) scale(0) rotate(0deg); 
                }
                50% { 
                    opacity: 1; 
                    transform: translateY(-20px) scale(1) rotate(180deg); 
                }
                100% { 
                    opacity: 0; 
                    transform: translateY(-40px) scale(0) rotate(360deg); 
                }
            }
        `;
        document.head.appendChild(sparkleStyle);

        createSparkles();
    </script>
</body>
</html>