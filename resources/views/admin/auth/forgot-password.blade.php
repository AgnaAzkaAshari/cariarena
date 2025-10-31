<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - CariArena</title>
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
            backdrop-filter: blur(10px);
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            padding: 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
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
            border-radius: 10px;
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

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            border: none;
            border-radius: 10px;
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

        .btn-secondary {
            background: #718096;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            box-shadow: 0 4px 12px rgba(113, 128, 150, 0.2);
            min-height: 48px;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(113, 128, 150, 0.3);
            background: #5a6268;
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

        /* Style khusus untuk halaman lupa password */
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 4px;
        }

        .step {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #E2E8F0;
            color: #718096;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .step.active {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .step.completed {
            background: var(--success);
            color: white;
        }

        .step-line {
            position: absolute;
            top: 50%;
            left: 100%;
            width: 16px;
            height: 2px;
            background: #E2E8F0;
            transform: translateY(-50%);
        }

        .step:last-child .step-line {
            display: none;
        }

        .step-content {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(8px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .step-hidden {
            display: none;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 16px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            padding: 6px 0;
        }

        .back-link:hover {
            color: var(--primary-hover);
        }

        .success-icon {
            font-size: 3rem;
            color: var(--success);
            margin-bottom: 16px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .button-group .btn {
            flex: 1;
        }

        /* PERBAIKAN RESPONSIVE UNTUK MOBILE */
        @media (max-width: 480px) {
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
            
            .login-header i {
                font-size: 1.8rem;
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
                border-radius: 8px;
            }
            
            .btn-login, .btn-secondary {
                padding: 12px;
                font-size: 14px;
                min-height: 44px;
                border-radius: 8px;
            }
            
            .step-indicator {
                margin-bottom: 16px;
            }
            
            .step {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }
            
            .step-line {
                width: 12px;
            }
            
            .button-group {
                flex-direction: column;
                gap: 8px;
            }
            
            .button-group .btn {
                width: 100%;
            }
            
            .success-icon {
                font-size: 2.5rem;
            }
            
            .back-link {
                font-size: 0.8rem;
                margin-bottom: 14px;
            }
        }

        /* Responsive untuk layar sangat kecil */
        @media (max-width: 360px) {
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
            }

            .login-header h3 {
                font-size: 1.1rem;
            }
            
            .form-control {
                padding: 11px 13px;
            }
            
            .btn-login, .btn-secondary {
                padding: 11px;
                min-height: 42px;
            }
            
            .step {
                width: 26px;
                height: 26px;
                font-size: 0.7rem;
            }
        }

        /* Animasi form group */
        .form-group {
            margin-bottom: 16px;
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

        /* Text styling */
        .text-muted {
            color: #718096 !important;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .text-success {
            color: var(--success) !important;
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-key"></i>
                <h3>Reset Password</h3>
                <p>Atur ulang password akun Anda</p>
            </div>

            <div class="login-body">
                <a href="{{ route('admin.login') }}" class="back-link">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
                </a>

                <div class="step-indicator">
                    <div class="step completed" id="step1">1<span class="step-line"></span></div>
                    <div class="step active" id="step2">2<span class="step-line"></span></div>
                    <div class="step" id="step3">3</div>
                </div>

                <!-- Step 2: Verifikasi Kode -->
                <div class="step-content" id="step2-content">
                    <p class="text-muted mb-3">Masukkan kode verifikasi 6 digit dari email Anda</p>
                    
                    <div class="form-group">
                        <label for="verificationCode" class="form-label">
                            <i class="fas fa-shield-alt me-2"></i>Kode Verifikasi
                        </label>
                        <input type="text" class="form-control" id="verificationCode" maxlength="6" placeholder="123456" required>
                    </div>

                    <div class="button-group">
                        <button class="btn btn-secondary" id="prevStep2">Kembali</button>
                        <button class="btn btn-login" id="nextStep2">Verifikasi</button>
                    </div>
                </div>

                <!-- Step 3: Reset Password (Hidden) -->
                <div class="step-content step-hidden" id="step3-content">
                    <p class="text-muted mb-3">Buat password baru Anda</p>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Password Baru
                        </label>
                        <input type="password" class="form-control" id="newPassword" placeholder="Minimal 8 karakter" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Konfirmasi Password
                        </label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Ulangi password baru" required>
                    </div>

                    <div class="button-group">
                        <button class="btn btn-secondary" id="prevStep3">Kembali</button>
                        <button class="btn btn-login" id="resetPassword">Reset Password</button>
                    </div>
                </div>

                <!-- Success Message (Hidden) -->
                <div class="step-content step-hidden text-center" id="success-content">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h5 class="text-success mb-2">Password Berhasil Direset!</h5>
                    <p class="text-muted mb-3">Silakan login dengan password baru Anda.</p>
                    <a href="{{ route('admin.login') }}" class="btn btn-login">Login Sekarang</a>
                </div>

                <div class="login-footer">
                    <p>&copy; 2025 CariArena. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 2;

        function updateStep() {
            // Sembunyikan semua step content
            document.getElementById('step2-content').classList.add('step-hidden');
            document.getElementById('step3-content').classList.add('step-hidden');
            document.getElementById('success-content').classList.add('step-hidden');

            // Update step indicator
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step3').classList.remove('active');

            // Set step yang aktif
            if (currentStep === 2) {
                document.getElementById('step2-content').classList.remove('step-hidden');
                document.getElementById('step2').classList.add('active');
                document.getElementById('step1').classList.add('completed');
            } else if (currentStep === 3) {
                document.getElementById('step3-content').classList.remove('step-hidden');
                document.getElementById('step3').classList.add('active');
                document.getElementById('step1').classList.add('completed');
                document.getElementById('step2').classList.add('completed');
            } else if (currentStep === 4) {
                document.getElementById('success-content').classList.remove('step-hidden');
                document.getElementById('step1').classList.add('completed');
                document.getElementById('step2').classList.add('completed');
                document.getElementById('step3').classList.add('completed');
            }
        }

        // Step navigation
        document.getElementById('prevStep2').addEventListener('click', function() {
            // Kembali ke halaman input email (step 1)
            window.location.href = "{{ route('admin.forgot-password') }}";
        });

        document.getElementById('nextStep2').addEventListener('click', function() {
            const code = document.getElementById('verificationCode').value;
            if (!code || code.length !== 6) {
                alert('Silakan masukkan kode verifikasi 6 digit');
                return;
            }
            
            // Show loading state
            this.classList.add('btn-loading');
            
            // Simulate API call dan lanjut ke step 3
            setTimeout(() => {
                this.classList.remove('btn-loading');
                currentStep = 3;
                updateStep();
            }, 1000);
        });

        document.getElementById('prevStep3').addEventListener('click', function() {
            currentStep = 2;
            updateStep();
        });

        document.getElementById('resetPassword').addEventListener('click', function() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (!newPassword || newPassword.length < 8) {
                alert('Password harus minimal 8 karakter');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                alert('Password dan konfirmasi password tidak cocok');
                return;
            }
            
            // Show loading state
            this.classList.add('btn-loading');
            
            // Simulate API call
            setTimeout(() => {
                currentStep = 4;
                updateStep();
            }, 1500);
        });

        // Auto-focus on verification code field
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('verificationCode');
            if (!codeInput.value) {
                codeInput.focus();
            }
        });

        // Auto move to next input when digit is entered
        document.getElementById('verificationCode').addEventListener('input', function(e) {
            if (this.value.length === 6) {
                document.getElementById('nextStep2').focus();
            }
        });
    </script>
</body>
</html>