<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - OJT Management System</title>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('{{ asset('logo.png') }}') center center no-repeat fixed;
            background-size: contain;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
            transition: filter 0.3s ease;
        }

        .container {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            max-width: 440px;
            width: 100%;
            overflow: hidden;
            z-index: 1;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.6s ease-out;
            transition: filter 0.3s ease;
        }

        .form-container {
            padding: 30px 40px;
        }

        .form-title {
            text-align: center;
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 14px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .submit {
            width: 100%;
            background: linear-gradient(135deg, #457b9d, #1d3557);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .submit:hover {
            background: linear-gradient(135deg, #1d3557, #457b9d);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: white;
            text-decoration: underline;
        }

        .security-indicator {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #22c55e;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            margin-bottom: 15px;
            text-align: center;
        }

        .security-indicator i {
            margin-right: 5px;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            text-align: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Blur effect for SweetAlert */
        body.swal2-shown::before {
            filter: blur(8px);
        }

        body.swal2-shown .container {
            filter: blur(8px);
        }

        .swal2-container {
            filter: none !important;
            backdrop-filter: none !important;
        }

        .swal2-popup {
            filter: none !important;
            backdrop-filter: none !important;
            transform: scale(1.05) !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
        }

        .swal2-backdrop-show {
            background-color: rgba(0, 0, 0, 0.6) !important;
        }

        .swal2-show {
            animation: sweetAlertFocus 0.4s ease-out !important;
        }

        @keyframes sweetAlertFocus {
            0% {
                opacity: 0;
                transform: scale(0.8) translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: scale(1.05) translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="form-title">Reset Password</h2>
        
        <div class="security-indicator">
            <i>🔒</i> Secure Password Reset • Argon2id Protected
        </div>

        <form method="POST" action="{{ route('password.update') }}" id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <input type="email" name="email" value="{{ $email ?? old('email') }}" placeholder="Email Address" required autocomplete="email">
            @error('email')
                <div style="color: #f87171; font-size: 12px; margin-bottom: 10px;">{{ $message }}</div>
            @enderror
            
            <input type="password" name="password" placeholder="New Password (Min 8 chars)" required autocomplete="new-password" minlength="8">
            @error('password')
                <div style="color: #f87171; font-size: 12px; margin-bottom: 10px;">{{ $message }}</div>
            @enderror
            
            <input type="password" name="password_confirmation" placeholder="Confirm New Password" required autocomplete="new-password">
            @error('password_confirmation')
                <div style="color: #f87171; font-size: 12px; margin-bottom: 10px;">{{ $message }}</div>
            @enderror
            
            <button class="submit" type="submit">Reset Password</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">← Back to Login</a>
        </div>
    </div>
</div>

<script>
    // Password strength validation
    function validatePasswordStrength(password) {
        const minLength = 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /\d/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
        return {
            length: password.length >= minLength,
            upperCase: hasUpperCase,
            lowerCase: hasLowerCase,
            numbers: hasNumbers,
            specialChar: hasSpecialChar,
            score: [password.length >= minLength, hasUpperCase, hasLowerCase, hasNumbers, hasSpecialChar].filter(Boolean).length
        };
    }

    // Real-time password strength validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
        
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const strength = validatePasswordStrength(this.value);
                const strengthIndicator = document.createElement('div');
                strengthIndicator.className = 'password-strength';
                
                if (this.value.length > 0) {
                    if (strength.score < 3) {
                        strengthIndicator.innerHTML = '<span style="color: #ef4444;">Weak password</span>';
                    } else if (strength.score < 5) {
                        strengthIndicator.innerHTML = '<span style="color: #f59e0b;">Medium strength</span>';
                    } else {
                        strengthIndicator.innerHTML = '<span style="color: #22c55e;">Strong password</span>';
                    }
                    
                    const existing = this.parentNode.querySelector('.password-strength');
                    if (existing) existing.remove();
                    this.parentNode.appendChild(strengthIndicator);
                }
            });
        }

        // Password confirmation validation
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirmPassword = this.value;
                
                if (confirmPassword.length > 0) {
                    if (password !== confirmPassword) {
                        this.style.borderColor = '#ef4444';
                    } else {
                        this.style.borderColor = '#22c55e';
                    }
                } else {
                    this.style.borderColor = 'rgba(255, 255, 255, 0.35)';
                }
            });
        }

        // Form validation
        const form = document.getElementById('resetForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Password Mismatch!',
                        text: 'Passwords do not match.',
                        icon: 'error'
                    });
                    return false;
                }

                const strength = validatePasswordStrength(password);
                if (strength.score < 3) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Weak Password!',
                        text: 'Please choose a stronger password with at least 8 characters, including uppercase, lowercase, numbers, and special characters.',
                        icon: 'warning'
                    });
                    return false;
                }
            });
        }

        // Check for validation errors
        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '{{ $error }}\n';
            @endforeach
            
            Swal.fire({
                title: 'Validation Error!',
                text: errorMessages.trim(),
                icon: 'error',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                allowOutsideClick: false,
                backdrop: 'rgba(0,0,0,0.7)',
                focusConfirm: true,
                allowEscapeKey: false
            });
        @endif

        // Check for success message
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                allowOutsideClick: false,
                backdrop: 'rgba(0,0,0,0.7)',
                focusConfirm: true,
                allowEscapeKey: false
            }).then(() => {
                window.location.href = '{{ route('login') }}';
            });
        @endif
    });
</script>

</body>
</html>













