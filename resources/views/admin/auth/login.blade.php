<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - CariArena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4A90E2;
            --primary-hover: #6AA7EC;
            --primary-light: #E3F2FD;
            --text-dark: #1A202C;
            --text-light: #718096;
            --bg-light: #EDF2F7;
            --card-bg: #FFFFFF;
            --success: #48BB78;
            --warning: #ECC94B;
            --danger: #F56565;
            --border-radius: 10px;
        }

        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            min-height: 100vh;
            background: linear-gradient(120deg, #dff3ff 0%, #e8f4ff 40%, #b7dbff 80%, #a0c4ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
            border: none;
            position: relative;
            z-index: 1;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            padding: 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Styling khusus untuk ikon bola voli */
        .volleyball-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        .login-header h3 {
            font-weight: 700;
            margin: 0;
            font-size: 1.4rem;
        }

        .login-header p {
            margin: 8px 0 0 0;
            opacity: 0.9;
            font-size: 0.85rem;
        }

        .login-body {
            padding: 24px;
        }

        .form-control {
            border: 2px solid #E2E8F0;
            border-radius: var(--border-radius);
            padding: 14px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #fff;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            z-index: 10;
            padding: 8px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .password-toggle:hover {
            color: var(--primary-color);
            background: rgba(74, 144, 226, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            border: none;
            border-radius: var(--border-radius);
            padding: 14px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
            min-height: 48px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.3);
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            margin-top: 0.2rem;
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-light);
            font-size: 0.85rem;
            cursor: pointer;
            margin-bottom: 0;
        }

        /* Layout untuk Ingat Saya dan Lupa Password */
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: color 0.3s ease;
            white-space: nowrap;
        }

        .forgot-password:hover {
            color: var(--primary-hover);
        }

        .register-link {
            text-align: center;
            margin: 20px 0 0 0;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #E2E8F0;
        }

        .login-footer p {
            color: var(--text-light);
            font-size: 0.75rem;
            margin: 0;
        }

        /* Alert styling */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #FED7D7;
            color: #C53030;
            border-left: 4px solid #F56565;
        }

        .alert-success {
            background-color: #C6F6D5;
            color: #276749;
            border-left: 4px solid #48BB78;
        }

        /* Loading state */
        .btn-loading {
            position: relative;
            color: transparent;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            top: 50%;
            left: 50%;
            margin-left: -9px;
            margin-top: -9px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-right-color: transparent;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Memastikan semua input memiliki border radius yang konsisten */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            border-radius: var(--border-radius) !important;
        }

        .input-group .form-control {
            padding-right: 50px;
        }

        /* PERBAIKAN RESPONSIVE UNTUK MOBILE */
        @media (max-width: 480px) {
            :root {
                --border-radius: 8px;
            }
            
            body {
                padding: 12px;
            }
            
            .login-container {
                max-width: 100%;
            }
            
            .login-card {
                border-radius: 14px;
                box-shadow: 0 6px 24px rgba(0,0,0,0.1);
            }
            
            .login-header {
                padding: 20px;
            }
            
            .login-body {
                padding: 20px;
            }
            
            .volleyball-icon {
                font-size: 2rem;
                margin-bottom: 10px;
            }
            
            .login-header h3 {
                font-size: 1.2rem;
            }
            
            .login-header p {
                font-size: 0.8rem;
            }
            
            .form-control {
                padding: 12px 14px;
                font-size: 16px;
                border-radius: var(--border-radius);
            }
            
            .btn-login {
                padding: 12px;
                font-size: 14px;
                min-height: 44px;
                border-radius: var(--border-radius);
            }
            
            /* Layout mobile untuk login options */
            .login-options {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                gap: 15px;
                margin-bottom: 16px;
            }
            
            .remember-me {
                flex-shrink: 0;
            }
            
            .forgot-password {
                font-size: 0.8rem;
            }
            
            .password-toggle {
                width: 36px;
                height: 36px;
                right: 8px;
                border-radius: 6px;
            }
            
            .register-link {
                margin-top: 16px;
            }
            
            .login-footer {
                margin-top: 16px;
                padding-top: 16px;
            }
            
            .alert {
                border-radius: var(--border-radius);
            }
        }

        /* Responsive untuk layar sangat kecil */
        @media (max-width: 360px) {
            :root {
                --border-radius: 6px;
            }
            
            body {
                padding: 8px;
            }
            
            .login-header {
                padding: 18px 16px;
            }

            .login-body {
                padding: 18px 16px;
            }

            .volleyball-icon {
                font-size: 1.8rem;
            }

            .login-header h3 {
                font-size: 1.1rem;
            }
            
            .form-control {
                padding: 11px 13px;
                border-radius: var(--border-radius);
            }
            
            .btn-login {
                padding: 11px;
                min-height: 42px;
                border-radius: var(--border-radius);
            }
            
            /* Layout untuk layar sangat kecil */
            .login-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .forgot-password {
                font-size: 0.75rem;
                align-self: flex-end;
            }
            
            .password-toggle {
                width: 32px;
                height: 32px;
                border-radius: 5px;
            }
        }

        /* Responsive untuk tablet */
        @media (min-width: 768px) and (max-width: 1024px) {
            .login-container {
                max-width: 450px;
            }
            
            .login-header {
                padding: 28px;
            }
            
            .login-body {
                padding: 28px;
            }
            
            .volleyball-icon {
                font-size: 2.8rem;
            }
        }

        /* Optimasi untuk landscape mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                padding: 10px;
                align-items: flex-start;
            }
            
            .login-container {
                margin: 10px auto;
            }
            
            .login-card {
                max-height: 90vh;
                overflow-y: auto;
            }
            
            .login-body {
                padding: 15px 15px;
            }
            
            .form-group {
                margin-bottom: 12px;
            }
            
            .login-options {
                margin-bottom: 15px;
            }
            
            .volleyball-icon {
                font-size: 1.8rem;
            }
        }

        /* Animasi form group */
        .form-group {
            margin-bottom: 20px;
        }

        .text-muted {
            color: #718096 !important;
            font-size: 0.85rem;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-volleyball-ball volleyball-icon"></i>
                <h3>CariArena Admin</h3>
                <p>Masuk ke dashboard administrator</p>
            </div>

            <div class="login-body">
                <!-- Alert messages -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Alamat Email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="masukkan email anda" required autofocus>
                        @error('email')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="masukkan password anda" required>
                            <button type="button" class="password-toggle" id="passwordToggle">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Layout untuk Ingat Saya dan Lupa Password -->
                    <div class="login-options">
                        <div class="remember-me">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="{{ route('admin.forgot-password') }}" class="forgot-password">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-login" id="loginButton">
                        <span id="loginText">Masuk ke Dashboard</span>
                    </button>

                    <p class="register-link">
                        Belum punya akun? 
                        <a href="{{ route('admin.register') }}">
                            Daftar di sini
                        </a>
                    </p>
                </form>

                <div class="login-footer">
                    <p>&copy; 2025 CariArena. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Form submission loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginButton = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            
            // Show loading state
            loginButton.classList.add('btn-loading');
            loginText.textContent = 'Memproses...';
            loginButton.disabled = true;
        });

        // Auto-focus on email field if empty
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (!emailInput.value) {
                emailInput.focus();
            }
            
            // Peningkatan untuk perangkat mobile: area sentuh yang lebih besar
            const passwordToggle = document.getElementById('passwordToggle');
            passwordToggle.style.minWidth = '36px';
            passwordToggle.style.minHeight = '36px';
            
            // Memastikan semua input memiliki border radius yang konsisten
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.style.borderRadius = 'var(--border-radius)';
            });
        });

        // Handle keyboard untuk mobile
        document.addEventListener('keydown', function(e) {
            // Tutup keyboard virtual ketika form submit
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement && activeElement.tagName === 'INPUT') {
                    activeElement.blur();
                }
            }
        });
    </script>
</body>
</html>