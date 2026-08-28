<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Intern Login</title>
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#2563eb">
    <link rel="icon" type="image/jpeg" href="{{ asset('ojt-logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('ojt-logo.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/pwa.css') }}">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Background image with overlay */
        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: url('{{ asset('ojt-logo.jpg') }}') center center no-repeat fixed;
            transition: filter 0.3s ease;
        }

        /* Dark overlay */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 0;
            transition: filter 0.3s ease;
        }

        /* Login card (Glassmorphism) */
        .login-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.14);
            padding: 36px 30px;
            border-radius: 18px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.6s ease-out;
            z-index: 1;
            position: relative;
            transition: filter 0.3s ease;
        }

        /* Title */
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #f1faee;
            font-weight: 700;
            font-size: 26px;
            letter-spacing: 0.5px;
            margin-top: 20px;
        }

        /* Input group */
        .form-group {
            position: relative;
            margin-bottom: 18px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 42px 12px 14px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 10px;
            color: #eef2ff;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-group input:focus {
            border-color: #a8dadc;
            box-shadow: 0 0 0 3px rgba(168, 218, 220, 0.35);
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-input-wrapper input {
            width: 100%;
            padding-right: 44px;
        }

        .toggle-password-btn {
            position: absolute;
            width: auto;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #eef2ff;
            padding: 4px;
            border-radius: 50%;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
        }

        .toggle-password-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: transparent;
            transform: translateY(-50%) scale(1.05);
        }

        .toggle-password-btn svg {
            position: static;
            transform: none;
            width: 18px;
            height: 18px;
        }

        /* Icons inside input */
        .form-group svg {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            width: 18px;
            height: 18px;
        }

        /* Submit button */
        button {
            width: 100%;
            padding: 12px 16px;
            background: linear-gradient(135deg, #457b9d, #1d3557);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
        }

        button:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #1d3557, #457b9d);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.3);
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 25px;
            }

            h2 {
                font-size: 22px;
                margin-top: 25px;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            overflow-y: auto;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            margin: 5% auto;
            padding: 30px;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            top: 15px;
            right: 20px;
        }

        .close:hover {
            color: #000;
        }

        /* Step Indicators */
        .step-indicators {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .step.active {
            background: linear-gradient(135deg, #457b9d, #1d3557);
            color: white;
            transform: scale(1.1);
        }

        .step.completed {
            background: #10b981;
            color: white;
        }

        /* Step Content */
        .step-content {
            display: none;
        }

        .step-content h3 {
            text-align: center;
            color: #1d3557;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .step-description {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
            font-size: 16px;
        }

        /* Form Styles */
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #1d3557;
            font-weight: 600;
            font-size: 14px;
        }

        .modal .form-group input,
        .modal .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            background: white;
            color: #1d3557;
        }

        .modal .form-group input:focus,
        .modal .form-group select:focus {
            outline: none;
            border-color: #457b9d;
            box-shadow: 0 0 0 3px rgba(69, 123, 157, 0.1);
        }

        .file-hint {
            font-size: 12px;
            color: #64748b;
            font-weight: normal;
        }

        .form-actions {
            text-align: center;
            margin-top: 30px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #457b9d, #1d3557);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: auto;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(69, 123, 157, 0.3);
        }

        /* Responsive Modal */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 10% auto;
                padding: 20px;
            }
            
            .step-indicators {
                gap: 15px;
            }
            
            .step {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }

        /* Blur ONLY the background and container when SweetAlert is active */
        body.swal2-shown::before {
            filter: blur(8px);
        }

        body.swal2-shown .login-container {
            filter: blur(8px);
        }

        /* Ensure SweetAlert popup is completely unaffected by blur */
        .swal2-container {
            filter: none !important;
            backdrop-filter: none !important;
        }

        .swal2-popup {
            filter: none !important;
            backdrop-filter: none !important;
        }

        /* Make SweetAlert stand out */
        .swal2-popup {
            transform: scale(1.05) !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
        }

        /* Make the backdrop darker for better focus */
        .swal2-backdrop-show {
            background-color: rgba(0, 0, 0, 0.6) !important;
        }

        /* Add subtle animation to SweetAlert */
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
    <div class="login-container">
        <h2>Intern Login</h2>

        <button type="button" class="pwa-install-btn intern-login-install" data-pwa-install>
            <i class="fas fa-download" aria-hidden="true"></i><span>Install App</span>
        </button>

        <form method="POST" action="{{ route('intern.login.submit') }}" autocomplete="off">
            @csrf
            <input type="text" name="intern_username_dummy" autocomplete="username" style="display:none" tabindex="-1">
            <input type="password" name="intern_password_dummy" autocomplete="new-password" style="display:none" tabindex="-1">
            <div class="form-group">
                <input type="email" name="email" placeholder="Intern Email" required autocomplete="username">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="form-group">
                <div class="password-input-wrapper">
                    <input type="password" id="intern-password" name="password" placeholder="Password" required autocomplete="current-password">
                    <button type="button" class="toggle-password-btn" onclick="togglePassword('intern-password', this)" aria-label="Show password">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
            </div>
            <button type="submit">Login</button>
        </form>

        <div style="margin-top: 20px; text-align: center;">
            <button type="button" onclick="try{openRegistrationModal();}catch(e){var m=document.getElementById('registrationModal'); if(m) m.style.display='block';} " style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                New Intern? Register Here
            </button>
        </div>

        <div style="margin-top: 15px; text-align: center;">
            <button type="button" onclick="showForgotPasswordModal()" style="background: transparent; border: 1px solid rgba(255, 255, 255, 0.3); color: rgba(255, 255, 255, 0.8); padding: 8px 16px; border-radius: 6px; font-size: 14px; cursor: pointer; transition: all 0.3s ease;">
                Forgot Password?
            </button>
        </div>
    </div>

    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRegistrationModal()">&times;</span>
            
            <div class="step-indicators">
                <div class="step active" data-step="1">1</div>
                <div class="step" data-step="2">2</div>
                <div class="step" data-step="3">3</div>
                <div class="step" data-step="4">4</div>
            </div>

            <div class="step-content" id="step1" style="display: block;">
                <h3>Pre-Enrollment Phase</h3>
                <p class="step-description">Please provide your basic information to start the registration process:</p>
                
                <form id="registrationForm" method="POST" action="{{ route('intern.store') }}">
                    @csrf
                    <input type="hidden" name="invited_token" id="invited_token">
                    
                    <div class="form-group">
                        <label>Invitation Link</label>
                        <input type="text" id="invitation_link_input" placeholder="Paste invitation link here">
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text" name="course" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Section</label>
                        <select name="section" required>
                            <option value="">Select Section</option>
                            <option value="North">North</option>
                            <option value="South">South</option>
                            <option value="West">West</option>
                            <option value="East">East</option>
                            <option value="Northeast">Northeast</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Supervisor Name</label>
                        <input type="text" name="supervisor_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Supervisor Position</label>
                        <input type="text" name="supervisor_position" placeholder="(Position)">
                    </div>
                    
                    <div class="form-group">
                        <label>Supervisor Email</label>
                        <input type="email" name="supervisor_email" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" name="company_name" placeholder="(Company Name)">
                    </div>
                    
                    <div class="form-group">
                        <label>Company Address</label>
                        <input type="text" name="company_address" placeholder="(Company Address)">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Submit Pre-Enrollment</button>
                    </div>
                </form>
            </div>

            <div class="step-content" id="step2">
                <h3>Pre-Deployment Phase</h3>
                <p class="step-description">Please submit the following documents:</p>
                
                <form id="preDeploymentForm" method="POST" action="{{ route('intern.submit.pre-deployment') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Resume <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="resume" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Application Letter <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="application_letter" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Medical Certificate <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="medical_certificate" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Insurance <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="insurance" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Acceptance Letter <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="acceptance_letter" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Notarized Parent's Waiver <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="parents_waiver" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Submit Pre-Deployment Documents</button>
                    </div>
                </form>
            </div>

            <div class="step-content" id="step3">
                <h3>Mid-Deployment Phase</h3>
                <p class="step-description">Please submit the following documents:</p>
                
                <form id="midDeploymentForm" method="POST" action="{{ route('intern.submit.mid-deployment') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Memorandum of Agreement <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="memorandum_of_agreement" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Internship Contract <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="internship_contract" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Submit Mid-Deployment Documents</button>
                    </div>
                </form>
            </div>

            <div class="step-content" id="step4">
                <h3>Deployment Phase</h3>
                <p class="step-description">Please submit the following document:</p>
                
                <form id="deploymentForm" method="POST" action="{{ route('intern.submit.deployment') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Recommendation Letter <span class="file-hint">(PDF, DOCX, JPG, PNG - Max 128 MB)</span></label>
                        <input type="file" name="recommendation_letter" accept=".pdf,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Submit Deployment Documents</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- OTP Verification Modal -->
    <div id="otpModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Verify Your Email</h2>
                <span class="close" onclick="closeOtpModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>We sent a 6-digit code to <b id="otpEmailLabel"></b>. Enter it below to verify.</p>
                <form id="otpForm" method="POST" action="{{ route('intern.otp.verify.submit') }}">
                    @csrf
                    <input type="hidden" name="email" id="otpEmail" value="">
                    <input 
                        type="text" 
                        name="otp" 
                        id="otpInput" 
                        maxlength="6" 
                        pattern="\d{6}"
                        required 
                        placeholder="Enter 6-digit code" 
                        inputmode="numeric"
                        style="width: 100%; padding: 12px; margin-bottom: 15px; border: 2px solid #ddd; border-radius: 6px; font-size: 18px; background: white; color: #333; box-sizing: border-box; letter-spacing: 6px; text-align: center;"
                    >
                    <div class="security-indicator">
                        <i>🔒</i> Code expires in 10 minutes
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="resendOtp()">Resend Code</button>
                <button class="btn btn-primary" onclick="submitOtp()">Verify</button>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Reset Password</h2>
                <span class="close" onclick="closeForgotPasswordModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Enter your email address and we'll send you an OTP code to reset your password.</p>
                <form id="forgotPasswordForm">
                    <input 
                        type="email" 
                        name="email" 
                        id="forgotPasswordEmail" 
                        placeholder="Enter your email address" 
                        required 
                        autocomplete="email"
                        style="width: 100%; padding: 12px; margin-bottom: 15px; border: 2px solid #ddd; border-radius: 6px; font-size: 14px; background: white; color: #333; box-sizing: border-box;"
                    >
                    <div class="security-indicator">
                        <i>🔒</i> OTP codes are valid for 10 minutes and can only be used once
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeForgotPasswordModal()">Cancel</button>
                <button class="btn btn-primary" onclick="sendForgotPasswordOtp()">Send OTP</button>
            </div>
        </div>
    </div>

    <!-- Forgot Password OTP Verification Modal -->
    <div id="forgotPasswordOtpModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Verify OTP</h2>
                <span class="close" onclick="closeForgotPasswordOtpModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>We sent a 6-digit code to <b id="forgotPasswordOtpEmailLabel"></b>. Enter it below to continue.</p>
                <form id="forgotPasswordOtpForm">
                    <input type="hidden" name="email" id="forgotPasswordOtpEmail" value="">
                    <input 
                        type="text" 
                        name="otp" 
                        id="forgotPasswordOtpInput" 
                        maxlength="6" 
                        pattern="\d{6}"
                        required 
                        placeholder="Enter 6-digit code" 
                        inputmode="numeric"
                        style="width: 100%; padding: 12px; margin-bottom: 15px; border: 2px solid #ddd; border-radius: 6px; font-size: 18px; background: white; color: #333; box-sizing: border-box; letter-spacing: 6px; text-align: center;"
                    >
                    <div class="security-indicator">
                        <i>🔒</i> Code expires in 10 minutes
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="resendForgotPasswordOtp()">Resend Code</button>
                <button class="btn btn-primary" onclick="verifyForgotPasswordOtp()">Verify</button>
            </div>
        </div>
    </div>

    <!-- New Password Modal -->
    <div id="newPasswordModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Set New Password</h2>
                <span class="close" onclick="closeNewPasswordModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Please enter your new password below.</p>
                <form id="newPasswordForm" method="POST" action="{{ route('intern.password.reset.submit') }}">
                    @csrf
                    <input type="hidden" name="email" id="newPasswordEmail" value="">
                    <input type="hidden" name="otp" id="newPasswordOtp" value="">
                    
                    <div class="form-group">
                        <label>New Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="newPassword" 
                            placeholder="Enter new password (Min 8 characters)" 
                            required 
                            minlength="8"
                            autocomplete="new-password"
                            style="width: 100%; padding: 12px; margin-bottom: 15px; border: 2px solid #ddd; border-radius: 6px; font-size: 14px; background: white; color: #333; box-sizing: border-box;"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="newPasswordConfirmation" 
                            placeholder="Confirm new password" 
                            required 
                            minlength="8"
                            autocomplete="new-password"
                            style="width: 100%; padding: 12px; margin-bottom: 15px; border: 2px solid #ddd; border-radius: 6px; font-size: 14px; background: white; color: #333; box-sizing: border-box;"
                        >
                    </div>
                    
                    <div class="security-indicator">
                        <i>🔒</i> Password will be encrypted using Argon2id algorithm
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeNewPasswordModal()">Cancel</button>
                <button class="btn btn-primary" onclick="submitNewPassword()">Reset Password</button>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const button = btn || (typeof event !== 'undefined' ? event.currentTarget : null);
            if (!input || !button) return;
            const icon = button.querySelector('svg');
            if (!icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><path d="M17.94 17.94A10.97 10.97 0 0 1 12 20c-7 0-11-8-11-8a21.5 21.5 0 0 1 5.1-6.06"/><path d="M6.06 6.06A10.97 10.97 0 0 1 12 4c7 0 11 8 11 8a21.5 21.5 0 0 1-5.1 6.06"/><path d="M9.88 9.88a3 3 0 0 0 4.24 4.24"/>';
                button.setAttribute('aria-label', 'Hide password');
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
                button.setAttribute('aria-label', 'Show password');
            }
        }

        let failedAttempts = parseInt(localStorage.getItem('internFailedAttempts')) || 0;
        let lockoutEndTime = parseInt(localStorage.getItem('internLockoutEndTime')) || 0;
        let backgroundTimerInterval = null;

        function getRemainingTime() {
            const now = Date.now();
            if (lockoutEndTime > now) {
                const remainingSeconds = Math.ceil((lockoutEndTime - now) / 1000);
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                return { 
                    locked: true, 
                    timeLeft: `${minutes}:${seconds.toString().padStart(2, '0')}`,
                    remainingSeconds: remainingSeconds
                };
            } else if (lockoutEndTime > 0) {
                localStorage.removeItem('internFailedAttempts');
                localStorage.removeItem('internLockoutEndTime');
                failedAttempts = 0;
                lockoutEndTime = 0;
                enableAllButtons();
                stopBackgroundTimer();
            }
            return { locked: false, timeLeft: '0:00', remainingSeconds: 0 };
        }

        function disableAllButtons() {
            document.querySelectorAll('button, input[type="submit"]').forEach(btn => {
                btn.disabled = true;
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
            });
        }

        function enableAllButtons() {
            document.querySelectorAll('button, input[type="submit"]').forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            });
        }

        function startBackgroundTimer() {
            if (backgroundTimerInterval) {
                clearInterval(backgroundTimerInterval);
            }
            
            backgroundTimerInterval = setInterval(() => {
                const status = getRemainingTime();
                if (!status.locked) {
                    stopBackgroundTimer();
                    enableAllButtons();
                }
            }, 1000);
        }

        function stopBackgroundTimer() {
            if (backgroundTimerInterval) {
                clearInterval(backgroundTimerInterval);
                backgroundTimerInterval = null;
            }
        }

        function openRegistrationModal() {
            document.getElementById('registrationModal').style.display = 'block';
            document.querySelectorAll('.step-indicators .step').forEach(step => step.classList.remove('active'));
            document.querySelectorAll('.step-content').forEach(content => content.style.display = 'none');
            document.getElementById('step1').style.display = 'block';
            document.querySelector('.step-indicators .step:nth-child(1)').classList.add('active');
        }

        function closeRegistrationModal() {
            document.getElementById('registrationModal').style.display = 'none';
        }

        // OTP Modal Functions
        function showOtpModal(email) {
            const modal = document.getElementById('otpModal');
            document.getElementById('otpEmail').value = email;
            document.getElementById('otpEmailLabel').textContent = email;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('otpInput').focus(), 150);
        }

        function closeOtpModal() {
            document.getElementById('otpModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function submitOtp() {
            const form = document.getElementById('otpForm');
            const input = document.getElementById('otpInput');
            const digits = (input.value || '').replace(/\D/g, '');
            if (digits.length !== 6) {
                Swal.fire('Invalid Code', 'Please enter the 6-digit code.', 'warning');
                input.focus();
                return;
            }
            input.value = digits;
            form.submit();
        }

        function resendOtp() {
            const email = document.getElementById('otpEmail').value;
            fetch('{{ route('intern.otp.resend') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ email })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    Swal.fire('Sent', 'A new code has been emailed to you.', 'success');
                    // In non-production, backend includes otp_fallback
                    if (data.otp_fallback) {
                        const input = document.getElementById('otpInput');
                        input.value = data.otp_fallback;
                    }
                } else {
                    Swal.fire('Error', data.message || 'Failed to resend code.', 'error');
                    if (data.otp_fallback) {
                        const input = document.getElementById('otpInput');
                        input.value = data.otp_fallback;
                    }
                }
            }).catch(() => Swal.fire('Error', 'Failed to resend code.', 'error'));
        }

        // Forgot Password Functions
        function showForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('forgotPasswordEmail').focus(), 150);
        }

        function closeForgotPasswordModal() {
            document.getElementById('forgotPasswordModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function sendForgotPasswordOtp() {
            const email = document.getElementById('forgotPasswordEmail').value;
            
            if (!email.trim()) {
                Swal.fire('Email Required', 'Please enter your email address.', 'warning');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Swal.fire('Invalid Email', 'Please enter a valid email address.', 'warning');
                return;
            }

            fetch('{{ route('intern.password.forgot') }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({ email })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    closeForgotPasswordModal();
                    showForgotPasswordOtpModal(email);
                    Swal.fire('OTP Sent', 'A verification code has been sent to your email.', 'success');
                    if (data.otp_fallback) {
                        setTimeout(() => {
                            const input = document.getElementById('forgotPasswordOtpInput');
                            input.value = data.otp_fallback;
                        }, 300);
                    }
                } else {
                    Swal.fire('Error', data.message || 'Failed to send OTP.', 'error');
                }
            }).catch(() => Swal.fire('Error', 'Failed to send OTP.', 'error'));
        }

        function showForgotPasswordOtpModal(email) {
            const modal = document.getElementById('forgotPasswordOtpModal');
            document.getElementById('forgotPasswordOtpEmail').value = email;
            document.getElementById('forgotPasswordOtpEmailLabel').textContent = email;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('forgotPasswordOtpInput').focus(), 150);
        }

        function closeForgotPasswordOtpModal() {
            document.getElementById('forgotPasswordOtpModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function verifyForgotPasswordOtp() {
            const email = document.getElementById('forgotPasswordOtpEmail').value;
            const otp = document.getElementById('forgotPasswordOtpInput').value;
            
            if (!otp || otp.length !== 6) {
                Swal.fire('Invalid Code', 'Please enter the 6-digit code.', 'warning');
                return;
            }

            fetch('{{ route('intern.password.verify-otp') }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({ email, otp })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    closeForgotPasswordOtpModal();
                    showNewPasswordModal(email, otp);
                    Swal.fire('OTP Verified', 'Please set your new password.', 'success');
                } else {
                    Swal.fire('Error', data.message || 'Invalid OTP code.', 'error');
                }
            }).catch(() => Swal.fire('Error', 'Failed to verify OTP.', 'error'));
        }

        function resendForgotPasswordOtp() {
            const email = document.getElementById('forgotPasswordOtpEmail').value;
            
            fetch('{{ route('intern.password.resend-otp') }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({ email })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    Swal.fire('Sent', 'A new code has been emailed to you.', 'success');
                    if (data.otp_fallback) {
                        const input = document.getElementById('forgotPasswordOtpInput');
                        input.value = data.otp_fallback;
                    }
                } else {
                    Swal.fire('Error', data.message || 'Failed to resend code.', 'error');
                }
            }).catch(() => Swal.fire('Error', 'Failed to resend code.', 'error'));
        }

        function showNewPasswordModal(email, otp) {
            const modal = document.getElementById('newPasswordModal');
            document.getElementById('newPasswordEmail').value = email;
            document.getElementById('newPasswordOtp').value = otp;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            setTimeout(() => document.getElementById('newPassword').focus(), 150);
        }

        function closeNewPasswordModal() {
            document.getElementById('newPasswordModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function submitNewPassword() {
            const form = document.getElementById('newPasswordForm');
            const password = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('newPasswordConfirmation').value;
            
            if (!password || password.length < 8) {
                Swal.fire('Invalid Password', 'Password must be at least 8 characters long.', 'warning');
                return;
            }
            
            if (password !== confirmPassword) {
                Swal.fire('Password Mismatch', 'Passwords do not match.', 'warning');
                return;
            }

            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            try { console.log('intern-login DOMContentLoaded'); } catch(e){}
            // Debug: log registration form submit events to help diagnose non-submitting clicks
            try {
                const regFormDebug = document.getElementById('registrationForm');
                if (regFormDebug) {
                    regFormDebug.addEventListener('submit', function(e){
                        try { console.log('registrationForm submit event fired'); } catch(err){}
                    });
                }
            } catch(e) {}
            // Parse invitation from query and bind input parsing
            const params = new URLSearchParams(window.location.search);
            const invite = params.get('invite');
            const hiddenTokenInput = document.getElementById('invited_token');
            const inviteInput = document.getElementById('invitation_link_input');
            if (invite) {
                // Verify token with backend
                fetch(`{{ route('api.invite.verify') }}?token=${encodeURIComponent(invite)}`)
                    .then(r => r.json())
                    .then(res => {
                        if (res.valid) {
                            hiddenTokenInput.value = invite;
                            if (inviteInput) inviteInput.value = window.location.href;
                            // enable fields
                            document.querySelectorAll('#registrationForm input, #registrationForm select').forEach(el => {
                                if (el.id !== 'invitation_link_input') {
                                    el.disabled = false;
                                }
                            });
                        } else {
                            Swal.fire({ title: 'Expired Link', text: 'The invitation link has expired.', icon: 'error', timer: 2000, showConfirmButton: false });
                        }
                    })
                    .catch(() => {
                        Swal.fire({ title: 'Expired Link', text: 'The invitation link has expired.', icon: 'error', timer: 2000, showConfirmButton: false });
                    });
            }
                    if (inviteInput) {
                inviteInput.addEventListener('input', function() {
                    try {
                        const url = new URL(this.value);
                        const qp = new URLSearchParams(url.search);
                        const t = qp.get('invite');
                        if (t) {
                            fetch(`{{ route('api.invite.verify') }}?token=${encodeURIComponent(t)}`)
                                .then(r => r.json())
                                .then(res => {
                                    if (res.valid) {
                                        hiddenTokenInput.value = t;
                                    } else {
                                        hiddenTokenInput.value = '';
                                        Swal.fire({ title: 'Expired Link', text: 'The invitation link has expired.', icon: 'error', timer: 1800, showConfirmButton: false });
                                    }
                                })
                                .catch(() => {
                                    hiddenTokenInput.value = '';
                                    Swal.fire({ title: 'Expired Link', text: 'The invitation link has expired.', icon: 'error', timer: 1800, showConfirmButton: false });
                                });
                        }
                    } catch (e) {
                        // ignore malformed
                    }
                });
            }
            const lockoutStatus = getRemainingTime();
            if (lockoutStatus.locked) {
                disableAllButtons();
                startBackgroundTimer();
                
                Swal.fire({
                    title: 'System Locked!',
                    html: `Too many failed attempts.<br>Please wait <b>${lockoutStatus.timeLeft}</b> before trying again.`,
                    icon: 'warning',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    didOpen: () => {
                        const content = Swal.getHtmlContainer();
                        const b = content.querySelector('b');
                        
                        const timerInterval = setInterval(() => {
                            const status = getRemainingTime();
                            if (status.locked) {
                                b.textContent = status.timeLeft;
                            } else {
                                clearInterval(timerInterval);
                                Swal.close();
                            }
                        }, 1000);
                    }
                });
            }

            @if(session('error'))
                failedAttempts++;
                localStorage.setItem('internFailedAttempts', failedAttempts);
                
                const attemptsLeft = 3 - failedAttempts;
                
                if (failedAttempts >= 3) {
                    const lockoutMinutes = 5;
                    lockoutEndTime = Date.now() + (lockoutMinutes * 60 * 1000);
                    localStorage.setItem('internLockoutEndTime', lockoutEndTime);
                    disableAllButtons();
                    startBackgroundTimer();
                    
                    Swal.fire({
                        title: 'Account Locked!',
                        html: 'Too many failed attempts.<br>Please wait <b>5:00</b> before trying again.',
                        icon: 'error',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        didOpen: () => {
                            const content = Swal.getHtmlContainer();
                            const b = content.querySelector('b');
                            
                            const timerInterval = setInterval(() => {
                                const status = getRemainingTime();
                                if (status.locked) {
                                    b.textContent = status.timeLeft;
                                } else {
                                    clearInterval(timerInterval);
                                    Swal.close();
                                }
                            }, 1000);
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Login Error!',
                        html: '{{ session('error') }}<br><br><b style="color: #fbbf24;">You only have ' + attemptsLeft + ' attempt' + (attemptsLeft > 1 ? 's' : '') + ' left!</b>',
                        icon: 'error',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                }
            @endif

            @if ($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '{{ $error }}\n';
                @endforeach
                
                Swal.fire({
                    title: 'Validation Error!',
                    text: errorMessages.trim(),
                    icon: 'error',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            @endif

            @if(session('success'))
                localStorage.removeItem('internFailedAttempts');
                localStorage.removeItem('internLockoutEndTime');
                failedAttempts = 0;
                lockoutEndTime = 0;
                stopBackgroundTimer();
                
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            @endif

            @if(session('document_success'))
                Swal.fire({
                    title: 'Documents Submitted!',
                    text: '{{ session('document_success') }}',
                    icon: 'success',
                    timer: 1500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            @endif

            // Open OTP modal automatically after registration
            @if(session('otp_email'))
                showOtpModal('{{ session('otp_email') }}');
                @if(session('otp_code_fallback'))
                    // Fallback: show OTP if email could not be sent
                    setTimeout(() => {
                        const input = document.getElementById('otpInput');
                        input.value = '{{ session('otp_code_fallback') }}';
                    }, 300);
                    Swal.fire({
                        title: 'Email Sending Issue',
                        html: 'We could not send the email. Use this code:<br><b>{{ session('otp_code_fallback') }}</b>',
                        icon: 'warning'
                    });
                @endif
            @endif

            const stepIndicators = document.querySelectorAll('.step-indicators .step');
            const stepContents = document.querySelectorAll('.step-content');
            let currentStep = 0;

            function showStep(stepIndex) {
                stepIndicators.forEach(indicator => indicator.classList.remove('active'));
                stepIndicators[stepIndex].classList.add('active');
                stepContents.forEach(content => content.style.display = 'none');
                stepContents[stepIndex].style.display = 'block';
                currentStep = stepIndex;
            }

            stepIndicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    if (index < currentStep) {
                        showStep(index);
                    } else if (index > currentStep) {
                        if (currentStep === 0) {
                            document.getElementById('registrationForm').submit();
                        } else if (currentStep === 1) {
                            document.getElementById('preDeploymentForm').submit();
                        } else if (currentStep === 2) {
                            document.getElementById('midDeploymentForm').submit();
                        } else if (currentStep === 3) {
                            document.getElementById('deploymentForm').submit();
                        }
                    }
                });
            });
        });

        // Close modals when clicking outside
        window.onclick = function(event) {
            const otpModal = document.getElementById('otpModal');
            const registrationModal = document.getElementById('registrationModal');
            const forgotPasswordModal = document.getElementById('forgotPasswordModal');
            const forgotPasswordOtpModal = document.getElementById('forgotPasswordOtpModal');
            const newPasswordModal = document.getElementById('newPasswordModal');
            
            if (event.target === otpModal) {
                closeOtpModal();
            }
            if (event.target === registrationModal) {
                closeRegistrationModal();
            }
            if (event.target === forgotPasswordModal) {
                closeForgotPasswordModal();
            }
            if (event.target === forgotPasswordOtpModal) {
                closeForgotPasswordOtpModal();
            }
            if (event.target === newPasswordModal) {
                closeNewPasswordModal();
            }
        }

        window.addEventListener('beforeunload', function() {
            // Timer data is already saved in localStorage
        });

        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                const status = getRemainingTime();
                if (!status.locked && lockoutEndTime > 0) {
                    localStorage.removeItem('internFailedAttempts');
                    localStorage.removeItem('internLockoutEndTime');
                    failedAttempts = 0;
                    lockoutEndTime = 0;
                    enableAllButtons();
                    stopBackgroundTimer();
                }
            }
        });
    </script>
    <script src="{{ asset('js/pwa.js') }}"></script>
</body>
</html>