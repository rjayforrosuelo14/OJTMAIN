<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Supervisor Registration - OJT Management System</title>
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
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --accent: #0891b2;
            --success: #059669;
            --danger: #dc2626;
            --warning: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --border-light: #e5e7eb;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,128C1248,117,1344,107,1392,101.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-attachment: fixed;
            z-index: 0;
        }

        .auth-container {
            position: relative;
            z-index: 1;
            max-width: 500px;
            width: 100%;
        }

        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 40px 30px;
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

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
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
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            margin-top: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.3);
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
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

        .alert-success {
            background: rgba(5, 150, 105, 0.1);
            border: 1px solid rgba(5, 150, 105, 0.3);
            color: var(--success);
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

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: var(--text-light);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
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

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fas fa-user-tie"></i> Supervisor Registration</h1>
                <p>Create a new supervisor account</p>
            </div>

            <div class="form-container">
                <!-- Registration Form -->
                <form id="supervisor-register-form" action="{{ route('supervisor.register.submit') }}" method="POST">
                    @csrf

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name"><i class="fas fa-user"></i> Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required value="{{ old('name') }}">
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required value="{{ old('email') }}">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Create a password (min 6 characters)" required minlength="6">
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation"><i class="fas fa-lock"></i> Confirm Password</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required minlength="6">
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions Info -->
                    <div style="background: #f0f9ff; border: 1px solid #bfdbfe; padding: 12px; border-radius: 8px; margin-bottom: 18px; font-size: 13px; color: #1e40af;">
                        <i class="fas fa-info-circle"></i> Your account will be pending approval by the admin before you can access the supervisor portal.
                    </div>

                    <!-- Register Button -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>

                    <!-- Login Link -->
                    <div class="login-link">
                        Already have an account? <a href="{{ route('supervisor.login') }}">Sign in here</a>
                    </div>

                    <!-- Back Link -->
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

        // Session messages
        @if (session('success'))
            Swal.fire({
                title: 'Registration Successful!',
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
