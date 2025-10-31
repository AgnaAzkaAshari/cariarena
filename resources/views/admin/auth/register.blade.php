<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin - CariArena</title>
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
            --border-radius: 10px; /* Variabel untuk konsistensi border radius */
        }

        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
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
        }

        .login-header i {
            font-size: 2.2rem;
            margin-bottom: 12px;
            display: block;
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

        .form-check-label {
            color: var(--text-light);
            font-size: 0.85rem;
            cursor: pointer;
            line-height: 1.4;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            font-size: 0.85rem;
            transition: color 0.3s ease;
            padding: 8px 0;
        }

        .back-link:hover {
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

        /* Password validation styling */
        .password-match {
            border-color: var(--success) !important;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.15) !important;
        }

        .password-mismatch {
            border-color: var(--danger) !important;
            box-shadow: 0 0 0 3px rgba(245, 101, 101, 0.15) !important;
        }

        .validation-message {
            font-size: 0.75rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            border-radius: 6px;
            padding: 4px 8px;
        }

        .validation-success {
            color: var(--success);
            background-color: rgba(72, 187, 120, 0.1);
        }

        .validation-error {
            color: var(--danger);
            background-color: rgba(245, 101, 101, 0.1);
        }

        /* PERBAIKAN RESPONSIVE UNTUK MOBILE - LEBIH OPTIMAL */
        @media (max-width: 480px) {
            :root {
                --border-radius: 8px; /* Border radius lebih kecil untuk mobile */
            }
            
            body {
                padding: 12px;
                background: linear-gradient(120deg, #dff3ff 0%, #e8f4ff 40%, #b7dbff 80%, #a0c4ff 100%);
            }
            
            .login-container {
                max-width: 100%;
            }
            
            .login-card {
                border-radius: 14px;
                box-shadow: 0 6px 24px rgba(0,0,0,0.1);
            }
            
            .login-header {
                padding: 20px 18px;
            }
            
            .login-body {
                padding: 20px 18px;
            }
            
            .login-header i {
                font-size: 1.8rem;
                margin-bottom: 10px;
            }
            
            .login-header h3 {
                font-size: 1.2rem;
            }
            
            .login-header p {
                font-size: 0.8rem;
                margin-top: 6px;
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
            
            .password-toggle {
                width: 36px;
                height: 36px;
                right: 8px;
                border-radius: 6px;
            }
            
            .back-link {
                margin-bottom: 16px;
                font-size: 0.8rem;
            }
            
            .register-link {
                margin-top: 16px;
            }
            
            .login-footer {
                margin-top: 16px;
                padding-top: 16px;
            }
            
            .form-group {
                margin-bottom: 16px;
            }
            
            .form-check-label {
                font-size: 0.8rem;
                line-height: 1.3;
            }
            
            .alert {
                border-radius: var(--border-radius);
            }
        }

        /* Responsive untuk layar sangat kecil (iPhone SE dll) */
        @media (max-width: 360px) {
            :root {
                --border-radius: 6px; /* Border radius lebih kecil untuk layar kecil */
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

            .login-header i {
                font-size: 1.6rem;
                margin-bottom: 8px;
            }

            .login-header h3 {
                font-size: 1.1rem;
            }
            
            .login-header p {
                font-size: 0.75rem;
            }
            
            .form-control {
                padding: 11px 12px;
                font-size: 16px;
                border-radius: var(--border-radius);
            }
            
            .btn-login {
                padding: 11px;
                min-height: 42px;
                font-size: 13px;
                border-radius: var(--border-radius);
            }
            
            .back-link {
                font-size: 0.75rem;
                margin-bottom: 14px;
            }
            
            .form-label {
                font-size: 0.85rem;
                margin-bottom: 6px;
            }
            
            .form-check-label {
                font-size: 0.75rem;
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
        }

        /* Animasi form group */
        .form-group {
            margin-bottom: 16px;
        }

        .text-muted {
            color: #718096 !important;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Perbaikan untuk form check yang panjang */
        .form-check {
            display: flex;
            align-items: flex-start;
        }

        .form-check-input {
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .form-check-label {
            flex: 1;
            padding-left: 8px;
        }
        
        /* Memastikan semua input memiliki border radius yang konsisten */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            border-radius: var(--border-radius) !important;
        }
        
        /* Memastikan tombol toggle password tidak mengganggu border radius */
        .input-group .form-control {
            padding-right: 50px; /* Ruang untuk tombol toggle */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-user-plus"></i>
                <h3>Daftar Admin</h3>
                <p>Buat akun administrator baru</p>
            </div>

            <div class="login-body">
                <a href="{{ route('admin.login') }}" class="back-link">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
                </a>

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

                <form method="POST" action="{{ route('admin.register.submit') }}" id="registerForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i>Nama Lengkap
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Masukkan nama lengkap" required autofocus>
                        @error('name')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Alamat Email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="email@example.com" required>
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
                                   id="password" name="password" placeholder="Minimal 8 karakter" required>
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

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Konfirmasi Password
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                            <button type="button" class="password-toggle" id="confirmPasswordToggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatchMessage" class="validation-message"></div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="agreeTerms" name="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                Saya menyetujui syarat dan ketentuan yang berlaku
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login" id="registerButton">
                        <span id="registerText">Daftar Sekarang</span>
                    </button>

                    <p class="register-link">
                        Sudah punya akun? 
                        <a href="{{ route('admin.login') }}">
                            Login di sini
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
        function setupPasswordToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            
            if (toggle && input) {
                toggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }
        }

        // Setup password toggles
        setupPasswordToggle('passwordToggle', 'password');
        setupPasswordToggle('confirmPasswordToggle', 'password_confirmation');

        // Password validation
        function validatePasswordMatch() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const messageElement = document.getElementById('passwordMatchMessage');
            
            if (password.value && confirmPassword.value) {
                if (password.value === confirmPassword.value) {
                    confirmPassword.classList.add('password-match');
                    confirmPassword.classList.remove('password-mismatch');
                    messageElement.innerHTML = '<i class="fas fa-check-circle me-2 validation-success"></i>Password cocok';
                    messageElement.className = 'validation-message validation-success';
                } else {
                    confirmPassword.classList.add('password-mismatch');
                    confirmPassword.classList.remove('password-match');
                    messageElement.innerHTML = '<i class="fas fa-exclamation-triangle me-2 validation-error"></i>Password tidak cocok';
                    messageElement.className = 'validation-message validation-error';
                }
            } else {
                confirmPassword.classList.remove('password-match', 'password-mismatch');
                messageElement.innerHTML = '';
            }
        }

        // Add event listeners for password validation
        document.getElementById('password').addEventListener('input', validatePasswordMatch);
        document.getElementById('password_confirmation').addEventListener('input', validatePasswordMatch);

        // Form submission loading state
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const registerButton = document.getElementById('registerButton');
            const registerText = document.getElementById('registerText');
            
            // Validate password match
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok');
                return;
            }
            
            // Validate password length
            if (password.length < 8) {
                e.preventDefault();
                alert('Password harus minimal 8 karakter');
                return;
            }
            
            // Validate terms agreement
            const agreeTerms = document.getElementById('agreeTerms').checked;
            if (!agreeTerms) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan');
                return;
            }
            
            // Show loading state
            registerButton.classList.add('btn-loading');
            registerText.textContent = 'Mendaftarkan...';
            registerButton.disabled = true;
        });

        // Auto-focus on name field if empty
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            if (!nameInput.value) {
                nameInput.focus();
            }
            
            // Optimasi untuk mobile: area sentuh yang lebih besar
            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(toggle => {
                toggle.style.minWidth = '36px';
                toggle.style.minHeight = '36px';
            });
            
            // Optimasi form check untuk mobile
            const formCheck = document.querySelector('.form-check');
            if (formCheck) {
                formCheck.style.alignItems = 'flex-start';
            }
            
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