<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Supervisor Login - OJT Management System</title>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --brand-primary: #2563eb;
            --brand-secondary: #6366f1;
            --brand-accent: #0891b2;
            --brand-success: #059669;
            --brand-danger: #dc2626;
            --brand-warning: #f59e0b;
            --text-dark: #0f172a;
            --text-light: #475569;
            --bg-light: #f8fafc;
            --border-light: rgba(37, 99, 235, 0.16);
            --card-bg: #ffffff;
            --card-border: rgba(37, 99, 235, 0.18);
            --shadow-black: 0 20px 60px rgba(15, 23, 42, 0.12);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 45%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%232563eb" fill-opacity="0.06" d="M0,192L48,170.7C96,149,192,107,288,112C384,117,480,171,576,202.7C672,235,768,245,864,218.7C960,192,1056,128,1152,101.3C1248,75,1344,85,1392,90.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-attachment: fixed;
            z-index: 0;
        }

        .auth-container {
            position: relative;
            z-index: 1;
            width: min(100%, 420px);
            max-width: 420px;
            margin: 20px;
        }

        .auth-card {
            background: var(--card-bg);
            border-radius: 18px;
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-black);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 60%, var(--brand-accent) 100%);
            padding: 42px 30px;
            text-align: center;
            color: white;
        }

        .auth-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .auth-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .form-container {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--border-light);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: white;
            color: var(--text-dark);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-group input::placeholder {
            color: var(--text-light);
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-input-wrapper input {
            width: 100%;
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 16px;
            padding: 5px;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        .btn {
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 65%, var(--brand-accent) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.28);
        }

        .form-link {
            text-align: center;
            margin-top: 14px;
            font-size: 14px;
            color: var(--text-light);
        }

        .form-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .form-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .forgot-password-button {
            width: auto;
            margin: 0;
            padding: 0;
            background: transparent;
            color: var(--primary);
            border: 0;
            border-radius: 0;
            font-size: inherit;
            font-weight: 600;
            letter-spacing: normal;
        }

        .forgot-password-button:hover {
            background: transparent;
            color: var(--primary-dark);
            box-shadow: none;
            text-decoration: underline;
            transform: none;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
            font-weight: 500;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: var(--danger);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--border-light);
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .auth-container {
                max-width: 100%;
            }

            .auth-header {
                padding: 30px 20px;
            }

            .auth-header h1 {
                font-size: 24px;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fas fa-building"></i> Company Portal</h1>
                <p>Supervisor & Company Login</p>
            </div>

            <div class="form-container">
                <!-- Supervisor/Company Login Form -->
                <form id="supervisor-login-form" action="{{ route('supervisor.login.submit') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="supervisor_username_dummy" autocomplete="username" style="display:none" tabindex="-1">
                    <input type="password" name="supervisor_password_dummy" autocomplete="new-password" style="display:none" tabindex="-1">

                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <div class="form-group">
                        <input type="email" id="supervisor-email" name="email" placeholder="Email Address" required autocomplete="username" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <div class="password-input-wrapper">
                            <input type="password" id="supervisor-password" name="password" placeholder="Password" required autocomplete="current-password">
                            <button type="button" class="toggle-password" onclick="togglePassword('supervisor-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>

                    <div class="form-link">
                        <button type="button" class="forgot-password-button" onclick="submitForgotPassword()">Forgot password?</button>
                    </div>

                    <div class="login-link" style="text-align: center; margin-top: 15px; font-size: 14px; color: var(--text-light);">
                        Don't have an account? <a href="{{ route('supervisor.register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Register here</a>
                    </div>

                    <div class="back-link">
                        <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Main Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = event.currentTarget;
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function submitForgotPassword() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('password.forgot') }}';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]').content;

            const email = document.createElement('input');
            email.type = 'hidden';
            email.name = 'email';
            email.value = document.getElementById('supervisor-email').value;

            form.append(csrf, email);
            document.body.appendChild(form);
            form.submit();
        }

        // Session messages
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#1e40af'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#dc2626'
            });
        @endif
    </script>
</body>
</html>
