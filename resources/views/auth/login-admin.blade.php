<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sistem Literasi Akhlak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-card fade-in">
            <div class="card-header-custom">
                <h2 class="auth-title">Login Admin</h2>
                <p class="auth-subtitle">Masuk ke Sistem Literasi Akhlak</p>
            </div>
            <div class="card-body-custom">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" name="email" id="email"
                                class="form-control search-input border-start-0" placeholder="Masukkan email" required>
                        </div>
                        @error('email')
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-lock text-muted"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                class="form-control search-input border-start-0" placeholder="Masukkan password"
                                required>
                        </div>
                        @error('password')
                            <div class="text-danger mt-1" style="font-size: 0.85rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-muted" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="btn btn-outline-custom">Register Admin Baru</a>
                </div>
                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                    <div class="alert alert-danger mt-3" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #3b82f6;
            --dark-blue: #1e40af;
            --accent-blue: #60a5fa;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        body {
            background: var(--bg-light);
            font-family: 'Inter', sans-serif;
        }

        .auth-card {
            background: var(--bg-white);
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            padding: 2rem;
            text-align: center;
            border: none;
        }


        .auth-title {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            font-weight: 400;
            font-size: 1rem;
            opacity: 0.9;
        }

        .card-body-custom {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .search-input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .input-group-text {
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            background: white;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-custom:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .auth-card {
                margin: 1rem;
            }

            .card-body-custom {
                padding: 1.5rem;
            }

            .auth-title {
                font-size: 1.5rem;
            }

            .auth-subtitle {
                font-size: 0.9rem;
            }

            /* Custom Checkbox Biru */
            .custom-check {
                border: 2px solid var(--primary-blue);
                border-radius: 6px;
                width: 18px;
                height: 18px;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .custom-check:checked {
                background-color: var(--primary-blue);
                border-color: var(--primary-blue);
            }

            .custom-check:focus {
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
            }

        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            // Placeholder for form submission feedback
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.classList.add('was-validated');
        });
    </script>
</body>

</html>
