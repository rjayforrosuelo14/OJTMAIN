<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login & Register - OJT Management System</title>
    <style>
        :root {
            color-scheme: dark;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --text: #F5F1F1;
            --muted: #C9BEBE;
            --accent: #E11D2E;
            --accent-strong: #B4121F;
            --accent-soft: #FF4D4D;
            --success: #10B981;
            --radius: 18px;
            --transition: 180ms ease;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            min-height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--text);
            min-height: 100vh;

            /* Full-page school photo background, darkened for legibility */
            background-image:
                linear-gradient(180deg, rgba(4,2,2,0.55) 0%, rgba(6,2,2,0.72) 55%, rgba(10,2,2,0.88) 100%),
                url("{{ asset('59e2b7de-f948-4175-a401-05c836537dc8.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            filter: contrast(1.04) saturate(1.08);
        }

        /* Undo the filter's effect on children so text/UI stays crisp; filter only applies to body's own background paint in supporting browsers */
        .page {
            filter: none;
        }

        .page {
            width: min(100%, 420px);
            max-width: 420px;
            display: grid;
            grid-template-columns: 1fr;
            justify-items: center;
            gap: 18px;
            padding: 22px;
            margin: 0 auto;
        }

        .hero {
            border-radius: 22px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(2rem, 3vw, 3rem);
            line-height: 1.05;
            text-shadow: 0 4px 24px rgba(0,0,0,0.65);
        }

        .hero p {
            margin: 22px 0 0;
            color: var(--muted);
            line-height: 1.8;
            max-width: 45ch;
            text-shadow: 0 2px 12px rgba(0,0,0,0.6);
        }

        .hero-tag {
            margin: 0 0 12px;
            color: #FF8080;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-size: 0.78rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.6);
        }

        .hero-features {
            margin-top: 32px;
            display: grid;
            gap: 14px;
        }

        .feature {
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: rgba(10, 4, 4, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
        }

        .feature-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-soft));
            box-shadow: 0 0 16px rgba(225, 29, 46, 0.5);
        }

        .form-panel {
            background: rgba(10, 6, 6, 0.72);
            backdrop-filter: blur(22px) saturate(1.1);
            -webkit-backdrop-filter: blur(22px) saturate(1.1);
            border-radius: 26px;
            padding: 44px 40px;
            border: 1px solid rgba(255,255,255,0.14);
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.55);
            display: flex;
            flex-direction: column;
            gap: 28px;
            width: 100%;
            max-width: 420px;
        }

        .form-header {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .form-header h2 {
            margin: 0;
            font-size: clamp(1.8rem, 2.4vw, 2.5rem);
        }

        .form-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.75;
        }

        .tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .tab {
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.04);
            color: var(--muted);
            font-weight: 700;
            cursor: pointer;
            transition: background var(--transition), color var(--transition);
        }

        .tab.active {
            background: linear-gradient(135deg, rgba(225,29,46,0.35), rgba(180,18,31,0.45));
            color: var(--text);
            border-color: rgba(225, 29, 46, 0.4);
        }

        .alt-button {
            display: block;
            width: 100%;
            padding: 17px 0;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.14);
            color: var(--text);
            background: rgba(255,255,255,0.04);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
        }

        .alt-button:hover {
            background: rgba(225,29,46,0.18);
            transform: translateY(-1px);
        }

        .fields {
            display: grid;
            gap: 22px;
        }

        .field {
            position: relative;
        }

        .field input {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 16px;
            background: rgba(20, 10, 10, 0.65);
            color: var(--text);
            padding: 22px 20px;
            font-size: 1.1rem;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
            position: relative;
            z-index: 1;
        }

        .field input:focus {
            background: rgba(20, 10, 10, 0.65);
            border-color: rgba(225, 29, 46, 0.6);
            box-shadow: 0 0 0 3px rgba(225, 29, 46, 0.18);
        }

        .field label {
            position: absolute;
            top: 50%;
            left: 18px;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            transition: transform var(--transition), font-size var(--transition), opacity var(--transition), z-index var(--transition);
            z-index: 0;
        }

        .field input:focus + label,
        .field input:not(:placeholder-shown) + label {
            transform: translateY(-120%);
            font-size: 0.82rem;
            opacity: 0.95;
            z-index: 2;
        }

        /* Password visibility toggle — professional icon button */
        .field .toggle-pass {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: transparent;
            border: none;
            border-radius: 10px;
            color: var(--muted);
            cursor: pointer;
            padding: 0;
            z-index: 2;
            transition: background var(--transition), color var(--transition);
        }

        .field .toggle-pass:hover {
            background: rgba(255,255,255,0.08);
            color: var(--text);
        }

        .field .toggle-pass:focus-visible {
            outline: 2px solid rgba(225, 29, 46, 0.6);
            outline-offset: 2px;
        }

        .field .toggle-pass svg {
            width: 23px;
            height: 23px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .field .toggle-pass .icon-eye-off {
            display: none;
        }

        .field .toggle-pass.is-visible .icon-eye {
            display: none;
        }

        .field .toggle-pass.is-visible .icon-eye-off {
            display: block;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .actions label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 1rem;
        }

        .actions input[type='checkbox'] {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
        }

        .actions button {
            border: none;
            background: transparent;
            color: var(--accent-soft);
            font-weight: 700;
            cursor: pointer;
            padding: 0;
            font-size: 1rem;
        }

        .submit-button {
            width: 100%;
            border: none;
            border-radius: 18px;
            padding: 20px 0;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: white;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform var(--transition), box-shadow var(--transition);
            box-shadow: 0 18px 42px rgba(225, 29, 46, 0.35);
        }

        .submit-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 22px 50px rgba(225, 29, 46, 0.45);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--muted);
            font-size: 1rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        .alt-actions {
            display: grid;
            gap: 14px;
        }

        .alt-actions a {
            display: block;
            text-align: center;
            padding: 17px 0;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.14);
            color: var(--text);
            background: rgba(255,255,255,0.04);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            transition: background var(--transition), transform var(--transition);
        }

        .alt-actions a:hover {
            background: rgba(225,29,46,0.18);
            transform: translateY(-1px);
        }

        .register-link {
            text-align: center;
            color: var(--muted);
        }

        .register-link button {
            background: none;
            border: none;
            color: var(--accent-soft);
            cursor: pointer;
            font-weight: 700;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(4, 2, 2, 0.78);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            z-index: 20;
        }

        .modal-backdrop.active {
            display: flex;
        }

        .modal {
            width: min(540px, 100%);
            border-radius: 22px;
            background: rgba(12, 6, 6, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 32px;
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.55);
        }

        .modal h3 {
            margin: 0 0 12px;
            font-size: 1.6rem;
        }

        .modal p {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.7;
        }

        .modal .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 14px;
            flex-wrap: wrap;
        }

        .ghost {
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.05);
            color: var(--text);
            border-radius: 16px;
            padding: 12px 18px;
            cursor: pointer;
        }

        .confirm {
            border: none;
            border-radius: 16px;
            padding: 12px 18px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: white;
            cursor: pointer;
        }

        @media (max-width: 860px) {
            .page {
                grid-template-columns: 1fr;
            }

            .hero {
                background: rgba(8, 3, 3, 0.4);
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 22px;
            }
        }

        @media (max-width: 620px) {
            body {
                background-attachment: scroll;
            }

            .page {
                padding: 18px;
            }

            .hero,
            .form-panel {
                padding: 24px;
            }

            .hero-features,
            .alt-actions {
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
       

        <section class="form-panel" aria-labelledby="auth-title">
        
            <div class="fields">
                <form id="loginForm" method="POST" action="{{ route('login.submit') }}" autocomplete="off">
                    @csrf
                    <input type="text" name="login_username_dummy" autocomplete="username" style="display:none" tabindex="-1">
                    <input type="password" name="login_password_dummy" autocomplete="new-password" style="display:none" tabindex="-1">
                    <div class="field">
                        <input type="email" name="admin_email" id="loginEmail" placeholder=" " required autocomplete="off">
                        <label for="loginEmail">Email address</label>
                    </div>
                    <div class="field">
                        <input type="password" name="admin_password" id="loginPassword" placeholder=" " required autocomplete="new-password">
                        <label for="loginPassword">Password</label>
                        <button type="button" class="toggle-pass" data-target="loginPassword" aria-label="Show password" aria-pressed="false">
                            <svg class="icon-eye" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z"/>
                                <circle cx="12" cy="12" r="3.2"/>
                            </svg>
                            <svg class="icon-eye-off" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 3l18 18"/>
                                <path d="M10.6 5.2A10.6 10.6 0 0 1 12 5c7 0 10.5 7 10.5 7a13.4 13.4 0 0 1-3.1 3.9"/>
                                <path d="M6.6 6.6C3.6 8.4 1.5 12 1.5 12s3.5 7 10.5 7a10.4 10.4 0 0 0 4.4-.9"/>
                                <path d="M9.5 9.7a3.2 3.2 0 0 0 4.6 4.4"/>
                            </svg>
                        </button>
                    </div>
                    <div class="actions">
                        <label><input type="checkbox" name="remember"> Remember me</label>
                        <button type="button" id="forgotTrigger">Forgot Password?</button>
                    </div>
                    <button type="submit" class="submit-button">Login</button>
                </form>

                <form id="registerForm" method="POST" action="{{ route('register') }}" autocomplete="on" style="display:none;">
                    @csrf
                    <div class="field">
                        <input type="text" name="name" id="registerName" placeholder=" " required autocomplete="name">
                        <label for="registerName">Full name</label>
                    </div>
                    <div class="field">
                        <input type="email" name="email" id="registerEmail" placeholder=" " required autocomplete="email">
                        <label for="registerEmail">Email</label>
                    </div>
                    <div class="field">
                        <input type="password" name="password" id="registerPassword" placeholder=" " required autocomplete="new-password" minlength="8">
                        <label for="registerPassword">Password</label>
                        <button type="button" class="toggle-pass" data-target="registerPassword" aria-label="Show password" aria-pressed="false">
                            <svg class="icon-eye" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z"/>
                                <circle cx="12" cy="12" r="3.2"/>
                            </svg>
                            <svg class="icon-eye-off" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 3l18 18"/>
                                <path d="M10.6 5.2A10.6 10.6 0 0 1 12 5c7 0 10.5 7 10.5 7a13.4 13.4 0 0 1-3.1 3.9"/>
                                <path d="M6.6 6.6C3.6 8.4 1.5 12 1.5 12s3.5 7 10.5 7a10.4 10.4 0 0 0 4.4-.9"/>
                                <path d="M9.5 9.7a3.2 3.2 0 0 0 4.6 4.4"/>
                            </svg>
                        </button>
                    </div>
                    <button type="submit" class="submit-button">Register</button>
                </form>
            </div>

            <div class="divider">OR</div>

            <div class="alt-actions">
                <a href="{{ route('supervisor.login') }}">Login as Supervisor</a>
                <a href="{{ route('intern.login') }}">Login as Intern</a>
                <button type="button" class="alt-button" onclick="showRegister()">Register</button>
            </div>

            <div class="register-link" id="register-link" style="display:none;">Already have an account? <button type="button" onclick="showLogin()">Sign in</button></div>
        </section>
    </main>

    <div class="modal-backdrop" id="forgotBackdrop" role="dialog" aria-modal="true" aria-labelledby="forgotHeading">
        <div class="modal">
            <h3 id="forgotHeading">Forgot Password</h3>
            <p>Enter your email address and we will send a reset link to regain access.</p>
            <form method="POST" action="{{ route('password.forgot') }}">
                @csrf
                <div class="field">
                    <input type="email" name="email" id="forgotEmail" placeholder=" " required autocomplete="email">
                    <label for="forgotEmail">Email address</label>
                </div>
                <div class="modal-actions">
                    <button type="button" class="ghost" id="forgotCancel">Cancel</button>
                    <button type="submit" class="confirm">Send reset link</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const registerLink = document.getElementById('register-link');
            const forgotBackdrop = document.getElementById('forgotBackdrop');
            const forgotTrigger = document.getElementById('forgotTrigger');
            const forgotCancel = document.getElementById('forgotCancel');

            function showLogin() {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                registerLink.style.display = 'none';
            }

            function showRegister() {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                registerLink.style.display = 'block';
            }

            function openForgot() {
                forgotBackdrop.classList.add('active');
                const emailField = document.getElementById('forgotEmail');
                if (emailField) emailField.focus();
            }

            function closeForgot() {
                forgotBackdrop.classList.remove('active');
            }

            function togglePassword(fieldId, button) {
                const input = document.getElementById(fieldId);
                const isVisible = input.type === 'password';
                input.type = isVisible ? 'text' : 'password';
                button.classList.toggle('is-visible', isVisible);
                button.setAttribute('aria-pressed', String(isVisible));
                button.setAttribute('aria-label', isVisible ? 'Hide password' : 'Show password');
            }

            // Wire up tab switching
            document.getElementById('registerToggle')?.addEventListener('click', showRegister);
            document.getElementById('showLoginLink')?.addEventListener('click', showLogin);

            // Wire up the Forgot Password modal
            forgotTrigger.addEventListener('click', openForgot);
            forgotCancel.addEventListener('click', closeForgot);

            // Close modal when clicking the dark overlay itself (not the modal box)
            forgotBackdrop.addEventListener('click', (event) => {
                if (event.target === forgotBackdrop) closeForgot();
            });

            // Close modal on Escape
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && forgotBackdrop.classList.contains('active')) {
                    closeForgot();
                }
            });

            // Wire up password show/hide toggles
            document.querySelectorAll('.toggle-pass').forEach(button => {
                const fieldId = button.getAttribute('data-target');
                if (fieldId) {
                    button.addEventListener('click', () => togglePassword(fieldId, button));
                }
            });

            // Expose for the "Register" / "Sign in" buttons still using onclick
            window.showLogin = showLogin;
            window.showRegister = showRegister;
        });
    </script>
</body>
</html>