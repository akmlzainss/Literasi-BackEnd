@extends('layouts.app')

@section('title', 'Pengaturan Admin')
@section('page-title', 'Pengaturan Admin & Profil')

@section('content')
<link rel="stylesheet" href="css/pengaturan.css">

<!-- Page Header -->
<div class="page-header">
    <div class="header-content">
        <div class="profile-section">
            <div class="avatar-container">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->guard('admin')->check() ? auth()->guard('admin')->user()->nama_pengguna ?? 'Admin' : 'Admin') }}&background=2563eb&color=fff&size=80"
                     alt="Profile" class="profile-avatar">
                <div class="avatar-overlay">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <div class="profile-info">
                <h1 class="page-title">
                    {{ auth()->guard('admin')->check() ? auth()->guard('admin')->user()->nama_pengguna ?? 'Admin' : 'Admin' }}
                </h1>
                <p class="page-subtitle">
                    {{ auth()->guard('admin')->check() ? 'Administrator Sistem Literasi Akhlak' : 'Silakan login' }}
                </p>
                <div class="status-badge">
                    <i class="fas fa-circle"></i>
                    <span>
                        {{ auth()->guard('admin')->check() && auth()->guard('admin')->user()->status_aktif == 1 ? 'Online' : 'Offline' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalEditProfile">
                <i class="fas fa-edit"></i>
                Edit Profil
            </button>
        </div>
    </div>
</div>

<!-- Profile Information Cards -->
<div class="row g-4 mb-4">
    <!-- Informasi Akun -->
    <div class="col-lg-4">
        <div class="info-card">
            <div class="card-header-info">
                <div class="card-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="card-content">
                    <h5>Informasi Akun</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="info-items-container">
                    <div class="info-item">
                        <span class="label">Email:</span>
                        <span class="value">{{ auth()->guard('admin')->user()->email ?? 'Tidak ada email' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Role:</span>
                        <span class="value">{{ auth()->guard('admin')->user()->nama_pengguna ?? 'Tidak ada nama' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Status:</span>
                        <span class="value status-active">
                            <i class="fas fa-circle"></i>
                            {{ auth()->guard('admin')->user()->status_aktif == 1 ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="label">Bergabung:</span>
                        <span class="value">
                            {{ \Carbon\Carbon::parse(auth()->guard('admin')->user()->dibuat_pada)->format('d F Y') ?? 'Tidak ada data' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keamanan -->
    <div class="col-lg-8">
        <div class="info-card">
            <div class="card-header-info">
                <div class="card-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="card-content">
                    <h5>Keamanan</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="security-items-container">
                    <div class="security-item">
                        <i class="fas fa-key text-success"></i>
                        <div class="security-info">
                            <div class="security-label">Password terakhir diubah:</div>
                            <div class="security-value">
                                {{ $admin->last_password_changed_at
                                    ? \Carbon\Carbon::parse($admin->last_password_changed_at)->diffForHumans()
                                    : 'Tidak diketahui' }}
                            </div>
                        </div>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-clock text-warning"></i>
                        <div class="security-info">
                            <div class="security-label">Login terakhir:</div>
                            <div class="security-value">
                                {{ $admin->last_login_at
                                    ? \Carbon\Carbon::parse($admin->last_login_at)->format('d M Y, H:i') . ' WIB'
                                    : 'Belum pernah login' }}
                            </div>
                        </div>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-desktop text-info"></i>
                        <div class="security-info">
                            <div class="security-label">Perangkat:</div>
                            <div class="security-value">
                                {{ $perangkat ?? 'Perangkat Tidak Dikenali' }}
                            </div>
                        </div>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        <div class="security-info">
                            <div class="security-label">IP Address:</div>
                            <div class="security-value">{{ $ipAddress ?? 'Tidak diketahui' }}</div>
                        </div>
                    </div>
                    <div class="security-item">
                        <i class="fas fa-wifi text-secondary"></i>
                        <div class="security-info">
                            <div class="security-label">Status Koneksi:</div>
                            <div class="security-value">
                                @if(isset($isOnline) && $isOnline)
                                    <span class="connection-status online">
                                        <i class="fas fa-circle"></i> Online
                                    </span>
                                @else
                                    <span class="connection-status offline">
                                        <i class="fas fa-circle"></i> Offline
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div id="notif-success" style="position: fixed; top: 20px; right: 20px; background: #4caf50; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">
        {{ session('success') }}
        <span id="notif-success-time"></span>
    </div>
@endif

@if(session('success'))
    <div id="notif-success" style="position: fixed; top: 20px; right: 20px; background: #4caf50; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">
        {{ session('success') }}
        <span id="notif-success-time"></span>
    </div>
@endif

@if(session('error'))
    <div id="notif-error" style="position: fixed; top: 20px; right: 20px; background: #f44336; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">
        {{ session('error') }}
    </div>
@endif

@push('scripts')
<!-- Include Theme Manager -->
<script src="{{ asset('js/theme-manager.js') }}"></script>

<script>
// Toggle Password Visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Time Ago Function
function timeAgo(seconds) {
    if (seconds < 60) return seconds + ' detik yang lalu';
    let minutes = Math.floor(seconds / 60);
    if (minutes < 60) return minutes + ' menit yang lalu';
    let hours = Math.floor(minutes / 60);
    if (hours < 24) return hours + ' jam yang lalu';
    let days = Math.floor(hours / 24);
    return days + ' hari yang lalu';
}

// Success Notification Handler
@if(session('success'))
(function(){
    const notif = document.getElementById('notif-success');
    const timeSpan = document.getElementById('notif-success-time');
    let start = Date.now();

    function updateTime() {
        let elapsed = Math.floor((Date.now() - start) / 1000);
        timeSpan.textContent = ' (' + timeAgo(elapsed) + ')';
    }

    updateTime();
    let interval = setInterval(updateTime, 1000);

    setTimeout(() => {
        notif.style.transition = 'opacity 0.5s ease';
        notif.style.opacity = '0';
        clearInterval(interval);
        setTimeout(() => notif.remove(), 500);
    }, 6000);
})();
@endif

// Error Notification Handler
@if(session('error'))
(function(){
    const notifError = document.getElementById('notif-error');
    setTimeout(() => {
        notifError.style.transition = 'opacity 0.5s ease';
        notifError.style.opacity = '0';
        setTimeout(() => notifError.remove(), 500);
    }, 6000);
})();
@endif

// Password Strength Checker
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new_password');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthContainer = document.querySelector('.password-strength');
            const strengthBar = document.querySelector('.strength-progress');
            const strengthText = document.querySelector('.strength-text');
            
            if (password.length > 0) {
                strengthContainer.style.display = 'block';
                
                let strength = 0;
                let feedback = [];

                if (password.length >= 8) strength++;
                else feedback.push('minimal 8 karakter');

                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                else feedback.push('huruf besar dan kecil');

                if (/\d/.test(password)) strength++;
                else feedback.push('angka');

                if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
                else feedback.push('karakter khusus');

                const strengthPercentage = (strength / 4) * 100;
                strengthBar.style.width = strengthPercentage + '%';

                if (strength <= 1) {
                    strengthBar.className = 'strength-progress weak';
                    strengthText.textContent = 'Password lemah - perlu ' + feedback.join(', ');
                } else if (strength <= 2) {
                    strengthBar.className = 'strength-progress medium';
                    strengthText.textContent = 'Password sedang - tambahkan ' + feedback.join(', ');
                } else if (strength <= 3) {
                    strengthBar.className = 'strength-progress good';
                    strengthText.textContent = 'Password baik - tambahkan ' + feedback.join(', ');
                } else {
                    strengthBar.className = 'strength-progress strong';
                    strengthText.textContent = 'Password sangat kuat!';
                }
            } else {
                strengthContainer.style.display = 'none';
            }
        });
    }
});

// Profile Photo Preview
document.addEventListener('DOMContentLoaded', function() {
    const profilePhotoInput = document.getElementById('profile_photo');
    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Form Submit AJAX for Edit Profile
document.addEventListener('DOMContentLoaded', function() {
    const editProfileForm = document.getElementById('editProfileForm');
    if (editProfileForm) {
        editProfileForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    showAlert('success', 'Profil berhasil diperbarui!');
                    
                    if (result.profile_photo_url) {
                        document.querySelector('.profile-avatar').src = result.profile_photo_url;
                        document.querySelector('.profile-preview').src = result.profile_photo_url;
                    }
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditProfile'));
                    if (modal) modal.hide();
                    
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showAlert('error', result.message || 'Gagal memperbarui profil.');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat memperbarui profil.');
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const themeRadios = document.querySelectorAll('input[name="tema_sistem"]');

    // Load tema tersimpan
    const savedTheme = localStorage.getItem('tema_sistem') || 'light';
    setTheme(savedTheme);

    // Event ganti tema
    themeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            setTheme(this.value);
            localStorage.setItem('tema_sistem', this.value);
        });
    });

    function setTheme(theme) {
        if (theme === 'dark') {
            body.classList.add('dark-mode');
            body.classList.remove('light-mode');
            document.getElementById('tema_dark').checked = true;
        } else {
            body.classList.add('light-mode');
            body.classList.remove('dark-mode');
            document.getElementById('tema_light').checked = true;
        }
    }
});

// Alert Function
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show custom-alert" role="alert">
            <i class="fas ${iconClass} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Remove existing alerts
    document.querySelectorAll('.custom-alert').forEach(alert => alert.remove());
    
    // Add new alert
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('.custom-alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}
</script>
@endpush

@push('styles')
<style>
.custom-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
    border-radius: 10px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Additional Dark Mode Styles for Bootstrap Components */
body.dark-mode .form-label {
    color: var(--text-dark);
}

body.dark-mode .text-muted {
    color: var(--text-light) !important;
}

body.dark-mode .modal-backdrop {
    background-color: rgba(0, 0, 0, 0.8);
}

body.dark-mode hr {
    border-color: var(--border-light);
}

/* Theme transition for all elements */
body.dark-mode *,
body.light-mode * {
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}
</style>
@endpush

@endsection