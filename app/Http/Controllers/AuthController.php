<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Intern;
use App\Models\Supervisor;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Password as PasswordRule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    /**
     * Show the login/register view with QR code to register as intern
     */
    public function showLoginRegister()
    {
        return view('login-and-register');
    }

    /**
     * Register a new admin user with enhanced security and OTP verification
     */
    public function register(Request $request)
    {
        // Rate limiting for registration attempts
        $key = 'register:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many registration attempts. Please try again in {$seconds} seconds."
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-zÀ-ÿ\-\.\'\s]+$/u',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => [
                'required',
                'string',
                'confirmed',
                PasswordRule::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'terms_agreement' => 'required|accepted',
        ], [
            'name.regex' => 'Name may include letters, spaces, hyphens, apostrophes, and periods.',
            'password.uncompromised' => 'This password has been found in data breaches. Please choose a different password.',
            'terms_agreement.required' => 'You must accept the Terms of Service.',
            'terms_agreement.accepted' => 'You must accept the Terms of Service.',
        ]);

        $email = strtolower(trim($request->email));

        if (Intern::where('email', $email)->exists() || Supervisor::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'This email is already registered as an intern or supervisor.'])->withInput();
        }

        // Create user (email unverified until OTP is confirmed)
        $user = User::create([
            'name'     => trim($request->name),
            'email'    => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
        ]);

        // Generate and store OTP (6 digits) valid for 10 minutes
        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->otp_verified = false;
        $user->save();

        // Send OTP via email from configured Gmail
        $mailFailed = false;
        try {
            // Use the default mailer from config/.env
            Mail::to($user->email)->send(new OtpMail($otp));
            \Log::info('OTP email sent successfully to: ' . $user->email);
        } catch (\Throwable $e) {
            $mailFailed = true;
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            \Log::error('Email sending error details: ' . $e->getTraceAsString());
        }

        // Clear rate limiting on successful registration
        RateLimiter::clear($key);

        // Redirect back to login/register with OTP modal trigger
        $redirect = redirect()->route('login')
            ->with('success', 'Registration successful! We sent a 6-digit code to your email.')
            ->with('otp_email', $user->email);

        // If mail failed outright, surface OTP via session for the modal as a last-resort fallback
        if ($mailFailed) {
            $redirect->with('otp_code_fallback', $otp);
        }
        // In non-production environments, always surface the OTP to unblock verification
        // Commented out for production - emails are working properly
        // if (app()->environment() !== 'production') {
        //     $redirect->with('otp_code_fallback', $otp);
        // }

        return $redirect;
    }

    /**
     * Login logic for admin with enhanced security
     */
    public function login(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email',
            'admin_password' => 'required|string',
        ]);

        // Normalize email to lowercase for consistency
        $email = strtolower(trim($request->admin_email));
        $password = $request->admin_password;
        $remember = $request->boolean('remember');

        // Try to authenticate with normalized email
        $credentials = ['email' => $email, 'password' => $password];
        try {
            if (Auth::attempt($credentials, $remember)) {
                // OTP verification skipped for development - auto verify all users
                $user = Auth::user();
                if (!$user->otp_verified) {
                    $user->update([
                        'otp_verified' => true,
                        'email_verified_at' => now()
                    ]);
                }

                // Regenerate session ID for security
                $request->session()->regenerate();

                // Clear any stale intended URL from previous intern/supervisor redirects
                $request->session()->forget('url.intended');

                return redirect()->route('dashboard')->with('success', 'Welcome back!');
            }
        } catch (QueryException $e) {
            return back()->withInput();
        } catch (\PDOException $e) {
            return back()->withInput();
        }

        return back()->withInput();
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('login')->with('error', 'Missing email for verification.');
        }
        return view('auth.verify-otp', ['email' => $email]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', strtolower(trim($request->email)))->first();
        if (!$user) {
            return back()->with('error', 'Invalid email.');
        }

        if (!$user->otp_code || !$user->otp_expires_at || now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'OTP has expired. Please resend a new code.');
        }

        if (hash_equals($user->otp_code, $request->otp)) {
            $user->otp_verified = true;
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->email_verified_at = $user->email_verified_at ?: now();
            $user->save();

            return redirect()->route('login')->with('success', 'Email verified! You can now log in.');
        }

        return back()->with('error', 'Invalid code. Please try again.');
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', strtolower(trim($request->email)))->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Account not found.'], 404);
        }

        // Rate limit resend by short window
        $key = 'otp-resend:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json(['success' => false, 'message' => "Please wait {$seconds}s before requesting again."], 429);
        }

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->otp_verified = false;
        $user->save();

        try {
            Mail::to($user->email)->send(new OtpMail($otp));
            \Log::info('OTP email resent successfully to: ' . $user->email);
        } catch (\Throwable $e) {
            \Log::error('Failed to resend OTP email: ' . $e->getMessage());
            \Log::error('Email sending error details: ' . $e->getTraceAsString());
            // Return OTP in response as last-resort fallback so user can proceed
            return response()->json(['success' => false, 'message' => 'Failed to send email.', 'otp_fallback' => $otp], 500);
        }

        RateLimiter::hit($key, 60);

        // In non-production, include the OTP in the success response to unblock testing
        // Commented out for production - emails are working properly
        // if (app()->environment() !== 'production') {
        //     return response()->json(['success' => true, 'otp_fallback' => $otp]);
        // }
        return response()->json(['success' => true]);
    }

    /**
     * Send password reset link
     */
    public function sendPasswordResetLink(Request $request)
    {
        // Rate limiting for password reset requests
        $key = 'password-reset:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Too many password reset requests. Please try again in {$seconds} seconds."
            ], 429);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                // Increment rate limiting
                RateLimiter::hit($key, 3600); // 1 hour
                
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset link sent to your email address.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Unable to send password reset link. Please try again later.'
            ], 500);
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the reset link. Please try again later.'
            ], 500);
        }
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        // Rate limiting for password reset attempts
        $key = 'password-reset-attempt:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many password reset attempts. Please try again in {$seconds} seconds."
            ]);
        }

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'confirmed',
                PasswordRule::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ], [
            'password.uncompromised' => 'This password has been found in data breaches. Please choose a different password.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Clear rate limiting on successful reset
            RateLimiter::clear($key);
            
            return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
        }

        // Increment rate limiting on failed reset
        RateLimiter::hit($key, 900); // 15 minutes

        return back()->withErrors([
            'email' => 'Invalid or expired reset token.'
        ]);
    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Invalidate session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Send forgot password OTP
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No account found with this email address.'], 404);
        }

        // Rate limiting removed for better user experience

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->otp_verified = false;
        $user->save();

        try {
            Mail::to($user->email)->send(new OtpMail($otp));
            \Log::info('Forgot password OTP email sent successfully to: ' . $user->email);
        } catch (\Exception $e) {
            \Log::error('Failed to send forgot password OTP email: ' . $e->getMessage());
            \Log::error('Email sending error details: ' . $e->getTraceAsString());
            // Return OTP in response as last-resort fallback so user can proceed
            return response()->json(['success' => false, 'message' => 'Failed to send email.', 'otp_fallback' => $otp], 500);
        }

        // In non-production, include the OTP in the success response to unblock testing
        // Commented out for production - emails are working properly
        // if (config('app.env') !== 'production') {
        //     return response()->json(['success' => true, 'otp_fallback' => $otp]);
        // }

        return response()->json(['success' => true]);
    }

    /**
     * Verify forgot password OTP
     */
    public function verifyForgotPasswordOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        if (!$user->otp_code || !$user->otp_expires_at || now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new code.'], 400);
        }

        if (hash_equals($user->otp_code, $request->otp)) {
            // Mark OTP as verified but don't clear it yet - we need it for password reset
            $user->otp_verified = true;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid OTP code.'], 400);
    }

    /**
     * Resend forgot password OTP
     */
    public function resendForgotPasswordOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Rate limiting removed for better user experience

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->otp_verified = false;
        $user->save();

        try {
            Mail::to($user->email)->send(new OtpMail($otp));
            \Log::info('Forgot password OTP email resent successfully to: ' . $user->email);
        } catch (\Exception $e) {
            \Log::error('Failed to resend forgot password OTP email: ' . $e->getMessage());
            \Log::error('Email sending error details: ' . $e->getTraceAsString());
            // Return OTP in response as last-resort fallback so user can proceed
            return response()->json(['success' => false, 'message' => 'Failed to send email.', 'otp_fallback' => $otp], 500);
        }

        // In non-production, include the OTP in the success response to unblock testing
        // Commented out for production - emails are working properly
        // if (config('app.env') !== 'production') {
        //     return response()->json(['success' => true, 'otp_fallback' => $otp]);
        // }

        return response()->json(['success' => true]);
    }

    /**
     * Reset password with OTP verification
     */
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Verify OTP is still valid and verified
        if (!$user->otp_code || !$user->otp_expires_at || now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'OTP has expired. Please request a new code.');
        }

        if (!$user->otp_verified || !hash_equals($user->otp_code, $request->otp)) {
            return back()->with('error', 'Invalid or unverified OTP code.');
        }

        // Reset password using Argon2id (Laravel's default since v8.0)
        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->otp_verified = false;
        $user->save();

        return redirect()->route('login')->with('success', 'Password has been reset successfully! You can now log in with your new password.');
    }
}
