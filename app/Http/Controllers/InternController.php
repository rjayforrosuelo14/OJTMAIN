<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class InternController extends Controller
{
    /**
     * Show a single intern detail page for admin viewing.
     */
    public function show($id)
    {
        $intern = Intern::findOrFail($id);

        return view('intern-show', compact('intern'));
    }

    /**
     * Show the edit page for a single intern.
     */
    public function edit($id)
    {
        $intern = Intern::findOrFail($id);

        return view('intern-edit', compact('intern'));
    }

    /**
     * Store a new intern via registration form (Pre-Enrollment Phase).
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:interns,email',
            'password' => 'required|min:6',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'section' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'supervisor_name' => 'required|string|max:100',
            'supervisor_position' => 'nullable|string|max:100',
            'supervisor_email' => 'required|email',
            'company_name' => 'nullable|string|max:150',
            'company_address' => 'nullable|string|max:255',
            'invited_token' => 'required|string',
        ]);

        $email = strtolower(trim($request->email));

        if (Supervisor::where('email', $email)->exists() || User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'This email is already registered as a supervisor or admin.'])->withInput();
        }

        // Create intern record; satisfy legacy NOT NULL columns with placeholders
        $invitedBy = null;
        if ($request->filled('invited_token')) {
            try {
                $decoded = json_decode(Crypt::decryptString($request->input('invited_token')), true);
                if (is_array($decoded) && isset($decoded['exp']) && isset($decoded['invited_by'])) {
                    if ($decoded['exp'] >= now()->timestamp) {
                        $invitedBy = (int) $decoded['invited_by'];
                    } else {
                        return back()->withErrors(['invited_token' => 'Expired Link'])->withInput();
                    }
                }
            } catch (\Throwable $e) {
                // Ignore invalid token
            }
        }

        $intern = Intern::create([
            'email' => $email,
            'password' => Hash::make($request->password), // Uses Argon2id by default
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'course' => $request->course,
            'section' => $request->section,
            'phone' => $request->phone,
            'supervisor_name' => $request->supervisor_name,
            'supervisor_position' => $request->supervisor_position,
            'supervisor_email' => $request->supervisor_email,
            'company_name' => $request->company_name ?? '',
            'company_address' => $request->company_address ?? '',
            // Legacy NOT NULL columns from initial schema
            'company_phone' => '',
            'application_letter' => '',
            'parents_waiver' => '',
            'acceptance_letter' => '',
            // Phase tracking
            'status' => 'pending',
            'current_phase' => 'pre_deployment', // Start directly at Pre-Deployment after registration
            'pre_enrollment_status' => 'pending',
            'invited_by_user_id' => $invitedBy,
            // OTP fields
            'otp_verified' => false,
        ]);

        // Generate and store OTP (6 digits) valid for 10 minutes
        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $intern->otp_code = $otp;
        $intern->otp_expires_at = now()->addMinutes(10);
        $intern->save();

        // Send OTP via email
        try {
            Mail::to($intern->email)->send(new OtpMail($otp));
            $mailSent = true;
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email to intern: ' . $e->getMessage());
            $mailSent = false;
        }

        // Redirect back to login/register with OTP modal trigger
        $redirect = redirect()->back()->with('success', "Registration successful! Please verify your email with the OTP code sent to your email address.")
            ->with('otp_email', $intern->email);

        // If mail failed outright, surface OTP via session for the modal as a last-resort fallback
        if (!$mailSent) {
            $redirect->with('otp_code_fallback', $otp);
        }

        // In non-production environments, always surface the OTP to unblock verification
        if (config('app.env') !== 'production') {
            $redirect->with('otp_code_fallback', $otp);
        }

        return $redirect;
    }

    public function verifyInvite(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return response()->json(['valid' => false, 'reason' => 'missing'], 400);
        }
        try {
            $decoded = json_decode(Crypt::decryptString($token), true);
            if (!is_array($decoded) || !isset($decoded['exp'])) {
                return response()->json(['valid' => false, 'reason' => 'invalid'], 400);
            }
            if ($decoded['exp'] < now()->timestamp) {
                return response()->json(['valid' => false, 'reason' => 'expired'], 200);
            }
            return response()->json(['valid' => true], 200);
        } catch (\Throwable $e) {
            return response()->json(['valid' => false, 'reason' => 'invalid'], 400);
        }
    }

    /**
     * Update an intern's editable fields (used by admin).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'course' => 'required|string|max:100',
            'section' => 'required|string|max:50',
        ]);

        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();
        $intern->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'course' => $request->course,
            'section' => $request->section,
        ]);

        return redirect()->back()->with('success', 'Intern updated successfully.');
    }

    /**
     * Delete an intern and optionally their files.
     */
    public function destroy($id)
    {
        $intern = Intern::findOrFail($id);

        // Delete documents from storage if exist
        Storage::disk('public')->delete([
            $intern->application_letter,
            $intern->parents_waiver,
            $intern->acceptance_letter,
        ]);

        $intern->delete();

        return redirect()->back()->with('success', 'Intern deleted successfully.');
    }

    /**
     * Accept an intern (allow login access).
     */
    public function accept($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();
        $intern->status = 'accepted';
        $intern->save();

        return redirect()->back()->with('success', 'Intern accepted and now able to log in.');
    }

    /**
     * Reject an intern (block login & hide from admin pending list).
     */
    public function reject($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();
        $intern->status = 'rejected';
        $intern->save();

        return redirect()->back()->with('success', 'Intern rejected and removed from list.');
    }

    /**
     * Accept Pre-Enrollment Phase
     */
    public function acceptPreEnrollment($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();
        $intern->pre_enrollment_status = 'accepted';
        $intern->pre_enrollment_accepted_at = now();
        $intern->current_phase = 'pre_deployment';
        $intern->save();

        return redirect()->back()->with('success', 'Pre-Enrollment Phase accepted. Intern can now proceed to Pre-Deployment Phase.');
    }

    /**
     * Accept Pre-Deployment Phase
     */
    public function acceptPreDeployment($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();
        $intern->pre_deployment_status = 'accepted';
        $intern->pre_deployment_accepted_at = now();
        $intern->current_phase = 'mid_deployment';
        $intern->save();

        return redirect()->back()->with('success', 'Pre-Deployment Phase accepted. Intern can now proceed to Mid-Deployment Phase.');
    }

    /**
     * Accept Mid-Deployment Phase
     */
    public function acceptMidDeployment($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();
        $intern->mid_deployment_status = 'accepted';
        $intern->mid_deployment_accepted_at = now();
        $intern->current_phase = 'deployment';
        $intern->save();

        return redirect()->back()->with('success', 'Mid-Deployment Phase accepted. Intern can now proceed to Deployment Phase.');
    }

    /**
     * Accept Deployment Phase
     */
    public function acceptDeployment($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();
        $intern->deployment_status = 'accepted';
        $intern->deployment_accepted_at = now();
        $intern->current_phase = 'completed';
        $intern->save();

        return redirect()->back()->with('success', 'Deployment Phase accepted. Intern has completed all phases.');
    }

    /**
     * Reject Pre-Deployment Phase and keep intern in pre_deployment to re-submit.
     */
    public function rejectPreDeployment($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();

        // Delete previously uploaded pre-deployment documents
        Storage::disk('public')->delete([
            $intern->resume,
            $intern->application_letter,
            $intern->medical_certificate,
            $intern->insurance,
            $intern->parents_waiver,
            $intern->acceptance_letter,
        ]);

        // Reset fields and status so intern can re-upload
        $intern->resume = null;
        $intern->application_letter = null;
        $intern->medical_certificate = null;
        $intern->insurance = null;
        $intern->parents_waiver = null;
        $intern->acceptance_letter = null;
        $intern->pre_deployment_status = null;
        $intern->current_phase = 'pre_deployment';
        $intern->save();

        return redirect()->back()->with('success', 'Pre-Deployment documents rejected. Intern will remain in Pre-Deployment to re-submit.');
    }

    /**
     * Reject Mid-Deployment Phase and revert intern to mid_deployment to re-submit.
     */
    public function rejectMidDeployment($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();

        // Delete previously generated mid-deployment documents
        Storage::disk('public')->delete([
            $intern->memorandum_of_agreement,
            $intern->internship_contract,
        ]);

        // Reset fields and status so intern can re-upload/regenerate
        $intern->memorandum_of_agreement = null;
        $intern->internship_contract = null;
        $intern->mid_deployment_status = null;
        $intern->current_phase = 'mid_deployment';
        $intern->save();

        return redirect()->back()->with('success', 'Mid-Deployment documents rejected. Intern will remain in Mid-Deployment to re-submit.');
    }

    /**
     * Reject Deployment Phase and revert intern to deployment to re-submit.
     */
    public function rejectDeployment($id)
    {
        $intern = Intern::where('id', $id)
            ->where('invited_by_user_id', Auth::id())
            ->firstOrFail();

        // Delete previously uploaded deployment documents
        Storage::disk('public')->delete([
            $intern->recommendation_letter,
            $intern->endorsement_letter,
        ]);

        // Reset fields and status so intern can re-upload/regenerate
        $intern->recommendation_letter = null;
        $intern->endorsement_letter = null;
        $intern->deployment_status = null;
        $intern->current_phase = 'deployment';
        $intern->save();

        return redirect()->back()->with('success', 'Deployment documents rejected. Intern will remain in Deployment to re-submit.');
    }

    /**
     * Submit Pre-Deployment documents
     */
    public function submitPreDeployment(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx',
            'application_letter' => 'required|file|mimes:pdf,doc,docx',
            'medical_certificate' => 'required|file|mimes:pdf,doc,docx',
            'insurance' => 'required|file|mimes:pdf,doc,docx',
            'parents_waiver' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $intern = Auth::guard('intern')->user();
        
        // Upload Pre-Deployment Phase documents
        $resume = $request->file('resume')->store('documents', 'public');
        $applicationLetter = $request->file('application_letter')->store('documents', 'public');
        $medicalCertificate = $request->file('medical_certificate')->store('documents', 'public');
        $insurance = $request->file('insurance')->store('documents', 'public');
        $parentsWaiver = $request->file('parents_waiver')->store('documents', 'public');

        // Auto-generate Acceptance Letter HTML and attach
        $start = now('Asia/Manila');
        $end = (clone $start)->addHours(486);
        $html = view('Acceptance-Letter', [
            'intern' => $intern,
            'startDate' => $start,
            'endDate' => $end,
        ])->render();
        $acceptancePath = 'documents/acceptance_letter_intern_' . $intern->id . '.html';
        Storage::disk('public')->put($acceptancePath, $html);

        $intern->update([
            'resume' => $resume,
            'application_letter' => $applicationLetter,
            'medical_certificate' => $medicalCertificate,
            'insurance' => $insurance,
            'acceptance_letter' => $acceptancePath,
            'parents_waiver' => $parentsWaiver,
            'pre_deployment_status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pre-Deployment documents submitted successfully. Please wait for admin acceptance.');
    }

    /**
     * Submit Mid-Deployment documents
     */
    public function submitMidDeployment(Request $request)
    {
        $request->validate([]);

        $intern = Auth::guard('intern')->user();
        
        // Auto-generate MOA and Contract HTML and attach
        $now = now('Asia/Manila');
        $moaHtml = view('memorandum', [
            'intern' => $intern,
            'today' => $now,
        ])->render();
        $moaPath = 'documents/memorandum_intern_' . $intern->id . '.html';
        Storage::disk('public')->put($moaPath, $moaHtml);

        $start = $now;
        $end = (clone $start)->addHours(486);
        $contractHtml = view('internship-contract', [
            'intern' => $intern,
            'startDate' => $start,
            'endDate' => $end,
            'today' => $now,
        ])->render();
        $contractPath = 'documents/internship_contract_intern_' . $intern->id . '.html';
        Storage::disk('public')->put($contractPath, $contractHtml);

        $intern->update([
            'memorandum_of_agreement' => $moaPath,
            'internship_contract' => $contractPath,
            'mid_deployment_status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Mid-Deployment documents submitted successfully. Please wait for admin acceptance.');
    }

    /**
     * Submit Deployment documents
     */
    public function submitDeployment(Request $request)
    {
        $request->validate([
            'recommendation_letter' => 'required|file|mimes:pdf,doc,docx',
            // endorsement_letter is auto-generated as HTML, no upload needed
        ]);

        $intern = Auth::guard('intern')->user();
        
        // Upload Deployment Phase documents
        $recommendationLetter = $request->file('recommendation_letter')->store('documents', 'public');
        // Endorsement letter is generated as HTML; store a marker/path if needed later
        $endorsementLetter = null;

        $intern->update([
            'recommendation_letter' => $recommendationLetter,
            'endorsement_letter' => $endorsementLetter,
            'deployment_status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Deployment documents submitted successfully. Please wait for admin acceptance.');
    }

    /**
     * View uploaded documents with proper content-type headers.
     */
    public function viewDocument($filename)
    {
        $filePath = storage_path('app/public/documents/' . $filename);
        
        if (!file_exists($filePath)) {
            abort(404, 'Document not found.');
        }

        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Set appropriate content-type headers based on file extension
        switch ($fileExtension) {
            case 'pdf':
                $contentType = 'application/pdf';
                break;
            case 'docx':
                $contentType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                break;
            case 'doc':
                $contentType = 'application/msword';
                break;
            case 'jpg':
            case 'jpeg':
                $contentType = 'image/jpeg';
                break;
            case 'png':
                $contentType = 'image/png';
                break;
            case 'gif':
                $contentType = 'image/gif';
                break;
            default:
                $contentType = 'application/octet-stream';
        }

        return response()->file($filePath, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    /**
     * Admin view: Render the auto-generated Endorsement letter as HTML for a specific intern.
     */
    public function viewEndorsement($id)
    {
        $intern = Intern::findOrFail($id);

        $data = [
            'supervisor_name' => $intern->supervisor_name,
            'supervisor_position' => $intern->supervisor_position,
            'company_name' => $intern->company_name,
            'company_address' => $intern->company_address,
            'interns' => [ $intern->first_name . ' ' . $intern->last_name ],
            'sentAt' => now('Asia/Manila'),
        ];

        return view('Endorsement', $data);
    }

    /**
     * Verify OTP for intern registration
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            return back()->with('error', 'Intern not found.');
        }

        if (!$intern->otp_code || !$intern->otp_expires_at || now()->greaterThan($intern->otp_expires_at)) {
            return back()->with('error', 'OTP has expired. Please resend a new code.');
        }

        if (hash_equals($intern->otp_code, $request->otp)) {
            $intern->otp_verified = true;
            $intern->otp_code = null;
            $intern->otp_expires_at = null;
            $intern->save();

            return redirect()->route('intern.login')->with('success', 'Email verified successfully! You can now log in.');
        }

        return back()->with('error', 'Invalid OTP code.');
    }

    /**
     * Resend OTP for intern registration
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            return response()->json(['success' => false, 'message' => 'Intern not found.'], 404);
        }

        // Rate limiting: max 3 resends per 5 minutes per IP
        $key = 'otp-resend-intern:' . $request->ip();
        $attempts = \Cache::get($key, 0);
        if ($attempts >= 3) {
            return response()->json(['success' => false, 'message' => 'Too many resend attempts. Please try again later.'], 429);
        }
        \Cache::put($key, $attempts + 1, 300); // 5 minutes

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $intern->otp_code = $otp;
        $intern->otp_expires_at = now()->addMinutes(10);
        $intern->otp_verified = false;
        $intern->save();

        try {
            Mail::to($intern->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to resend OTP email to intern: ' . $e->getMessage());
            // Return OTP in response as last-resort fallback so user can proceed
            return response()->json(['success' => false, 'message' => 'Failed to send email.', 'otp_fallback' => $otp], 500);
        }

        // In non-production, include the OTP in the success response to unblock testing
        if (config('app.env') !== 'production') {
            return response()->json(['success' => true, 'otp_fallback' => $otp]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Send forgot password OTP
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            return response()->json(['success' => false, 'message' => 'No account found with this email address.'], 404);
        }

        // Rate limiting removed for better user experience

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $intern->otp_code = $otp;
        $intern->otp_expires_at = now()->addMinutes(10);
        $intern->otp_verified = false;
        $intern->save();

        try {
            Mail::to($intern->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to send forgot password OTP email: ' . $e->getMessage());
            // Return OTP in response as last-resort fallback so user can proceed
            return response()->json(['success' => false, 'message' => 'Failed to send email.', 'otp_fallback' => $otp], 500);
        }

        // In non-production, include the OTP in the success response to unblock testing
        if (config('app.env') !== 'production') {
            return response()->json(['success' => true, 'otp_fallback' => $otp]);
        }

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

        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            return response()->json(['success' => false, 'message' => 'Intern not found.'], 404);
        }

        if (!$intern->otp_code || !$intern->otp_expires_at || now()->greaterThan($intern->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new code.'], 400);
        }

        if (hash_equals($intern->otp_code, $request->otp)) {
            // Mark OTP as verified but don't clear it yet - we need it for password reset
            $intern->otp_verified = true;
            $intern->save();

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

        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            return response()->json(['success' => false, 'message' => 'Intern not found.'], 404);
        }

        // Rate limiting removed for better user experience

        $otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $intern->otp_code = $otp;
        $intern->otp_expires_at = now()->addMinutes(10);
        $intern->otp_verified = false;
        $intern->save();

        try {
            Mail::to($intern->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to resend forgot password OTP email: ' . $e->getMessage());
            // Return OTP in response as last-resort fallback so user can proceed
            return response()->json(['success' => false, 'message' => 'Failed to send email.', 'otp_fallback' => $otp], 500);
        }

        // In non-production, include the OTP in the success response to unblock testing
        if (config('app.env') !== 'production') {
            return response()->json(['success' => true, 'otp_fallback' => $otp]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Reset password with OTP verification
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $intern = Intern::where('email', $request->email)->first();

        if (!$intern) {
            return back()->with('error', 'Intern not found.');
        }

        // Verify OTP is still valid and verified
        if (!$intern->otp_code || !$intern->otp_expires_at || now()->greaterThan($intern->otp_expires_at)) {
            return back()->with('error', 'OTP has expired. Please request a new code.');
        }

        if (!$intern->otp_verified || !hash_equals($intern->otp_code, $request->otp)) {
            return back()->with('error', 'Invalid or unverified OTP code.');
        }

        // Reset password using Argon2id (Laravel's default since v8.0)
        $intern->password = Hash::make($request->password);
        $intern->otp_code = null;
        $intern->otp_expires_at = null;
        $intern->otp_verified = false;
        $intern->save();

        return redirect()->route('intern.login')->with('success', 'Password has been reset successfully! You can now log in with your new password.');
    }
}

