<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\InternAuthController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AdminController;

// Public landing/login/register routes
Route::get('/', [InternAuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [AuthController::class, 'showLoginRegister'])->name('admin.login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// OTP and password reset routes
Route::get('/otp', [AuthController::class, 'showOtpForm'])->name('otp.verify');
Route::post('/otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
Route::post('/otp/resend', [AuthController::class, 'resendOtp'])->name('otp.resend');
Route::post('/password/email', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::get('/password/forgot', function () {
    return redirect()->route('supervisor.login');
});
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/password/forgot', [AuthController::class, 'forgotPassword'])->name('password.forgot');
Route::post('/password/verify-otp', [AuthController::class, 'verifyForgotPasswordOtp'])->name('password.verify-otp');
Route::post('/password/resend-otp', [AuthController::class, 'resendForgotPasswordOtp'])->name('password.resend-otp');
Route::post('/password/reset-submit', [AuthController::class, 'resetPasswordWithOtp'])->name('password.reset.submit');Route::get('/api/invite/verify', [InternController::class, 'verifyInvite'])->name('api.invite.verify');
// Supervisor public auth
Route::get('/supervisor/login', [SupervisorController::class, 'showLoginForm'])->name('supervisor.login');
Route::get('/supervisor/register', [SupervisorController::class, 'showRegisterForm'])->name('supervisor.register');
Route::post('/supervisor/login', [SupervisorController::class, 'login'])->name('supervisor.login.submit');
Route::post('/supervisor/register', [SupervisorController::class, 'register'])->name('supervisor.register.submit');

// Intern public auth
Route::get('/intern/login', [InternAuthController::class, 'showLoginForm'])->name('intern.login');
Route::post('/intern/login', [InternAuthController::class, 'login'])->name('intern.login.submit');
Route::post('/intern/logout', [InternAuthController::class, 'logout'])->name('intern.logout');
Route::post('/intern/store', [InternController::class, 'store'])->name('intern.store');
Route::post('/intern/verify-otp', [InternController::class, 'verifyOtp'])->name('intern.otp.verify.submit');
Route::post('/intern/resend-otp', [InternController::class, 'resendOtp'])->name('intern.otp.resend');
Route::post('/intern/password/forgot', [InternController::class, 'forgotPassword'])->name('intern.password.forgot');
Route::post('/intern/password/verify-otp', [InternController::class, 'verifyForgotPasswordOtp'])->name('intern.password.verify-otp');
Route::post('/intern/password/resend-otp', [InternController::class, 'resendForgotPasswordOtp'])->name('intern.password.resend-otp');
Route::post('/intern/password/reset', [InternController::class, 'resetPassword'])->name('intern.password.reset.submit');
Route::get('/intern/acceptance', [InternAuthController::class, 'acceptanceLetter'])->name('intern.acceptance');
Route::get('/intern/memorandum', [InternAuthController::class, 'memorandum'])->name('intern.memorandum');
Route::get('/intern/contract', [InternAuthController::class, 'internshipContract'])->name('intern.contract');
Route::get('/intern/endorsement', [InternAuthController::class, 'endorsement'])->name('intern.endorsement');

// Admin protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/interns', [DashboardController::class, 'interns'])->name('interns');
    Route::get('/documents', [DashboardController::class, 'documents'])->name('documents');
    Route::get('/documents/archive', [DashboardController::class, 'documentsArchive'])->name('documents.archive');
    Route::get('/documents/{id}/dtr', [TimeLogController::class, 'showDTR'])->name('documents.dtr');
    Route::get('/documents/{id}/journal', [JournalController::class, 'adminView'])->name('admin.journal');
    Route::get('/grades', [DashboardController::class, 'grades'])->name('grades');
    Route::post('/grades/request', [DashboardController::class, 'sendGradeRequest'])->name('grades.request');
    Route::get('/messages', [DashboardController::class, 'messages'])->name('messages');
    Route::get('/messages/{internId}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::post('/messages/send', [MessageController::class, 'sendToIntern'])->name('messages.send');
    Route::post('/messages/broadcast', [MessageController::class, 'broadcast'])->name('messages.broadcast');
    Route::delete('/messages/clear/{intern}', [MessageController::class, 'clearConversation'])->name('messages.clear');
    Route::get('/api/messages/{internId}/new', [MessageController::class, 'getNewMessages'])->name('api.messages.new');
    Route::get('/interns/invite-link', [DashboardController::class, 'generateInviteLink'])->name('interns.invite-link');
    Route::get('/qr', [DashboardController::class, 'qr'])->name('qr');
    Route::get('/show-qr-code', [QrCodeController::class, 'display'])->name('show.qr');
    Route::get('/supervisors', [SupervisorController::class, 'index'])->name('supervisors');
    Route::post('/supervisors/{id}/accept', [SupervisorController::class, 'accept'])->name('supervisor.accept');
    Route::post('/supervisors/{id}/reject', [SupervisorController::class, 'reject'])->name('supervisor.reject');
    Route::put('/supervisors/{id}/update', [SupervisorController::class, 'update'])->name('supervisor.update');
    Route::delete('/supervisors/{id}/delete', [SupervisorController::class, 'delete'])->name('supervisor.delete');
    Route::get('/interns/{id}/accept', [InternController::class, 'accept'])->name('intern.accept');
    Route::get('/interns/{id}/reject', [InternController::class, 'reject'])->name('intern.reject');
    Route::get('/interns/{id}/accept-pre-deployment', [InternController::class, 'acceptPreDeployment'])->name('intern.accept.pre-deployment');
    Route::get('/interns/{id}/accept-mid-deployment', [InternController::class, 'acceptMidDeployment'])->name('intern.accept.mid-deployment');
    Route::get('/interns/{id}/accept-deployment', [InternController::class, 'acceptDeployment'])->name('intern.accept.deployment');
    Route::get('/interns/{id}/reject-pre-deployment', [InternController::class, 'rejectPreDeployment'])->name('intern.reject.pre-deployment');
    Route::get('/interns/{id}/reject-mid-deployment', [InternController::class, 'rejectMidDeployment'])->name('intern.reject.mid-deployment');
    Route::get('/interns/{id}/reject-deployment', [InternController::class, 'rejectDeployment'])->name('intern.reject.deployment');
    Route::get('/admin/supervisors/{supervisor}/connect-interns', [AdminController::class, 'showConnectInternsForm'])->name('admin.connect-interns');
    Route::post('/admin/supervisors/{supervisor}/connect-interns', [AdminController::class, 'connectInterns'])->name('admin.connect-interns.save');
    Route::post('/admin/profile/avatar', [AdminController::class, 'uploadAvatar'])->name('admin.profile.avatar');
});

// Admin intern and route endpoints used by views
Route::middleware(['auth'])->group(function () {
    Route::get('/intern/{intern}', [InternController::class, 'show'])->whereNumber('intern')->name('intern.show');
    Route::get('/intern/{intern}/edit', [InternController::class, 'edit'])->whereNumber('intern')->name('intern.edit');
    Route::put('/intern/{intern}', [InternController::class, 'update'])->whereNumber('intern')->name('intern.update');
    Route::delete('/intern/{intern}', [InternController::class, 'destroy'])->whereNumber('intern')->name('intern.destroy');
});

// Supervisor protected routes
Route::middleware(['auth:supervisor'])->group(function () {
    Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard'])->name('supervisor.dashboard');
    Route::post('/supervisor/release-attendance', [SupervisorController::class, 'releaseAttendance'])->name('supervisor.releaseAttendance');
    Route::post('/supervisor/logout', [SupervisorController::class, 'logout'])->name('supervisor.logout');
    Route::post('/supervisor/mark-attendance/{internId}', [SupervisorController::class, 'markAttendance'])->name('supervisor.markAttendance');
    Route::post('/supervisor/select-incoming/{internId}', [SupervisorController::class, 'selectIncomingIntern'])->name('supervisor.selectIncoming');
    
    // Supervisor profile / avatar management
    Route::get('/supervisor/profile', [SupervisorController::class, 'profile'])->name('supervisor.profile');
    Route::post('/supervisor/profile/avatar', [SupervisorController::class, 'uploadAvatar'])->name('supervisor.profile.avatar');

    Route::get('/supervisor/messages', [MessageController::class, 'supervisorMessages'])->name('supervisor.messages');
    Route::get('/supervisor/messages/{internId}', [MessageController::class, 'supervisorConversation'])->name('supervisor.messages.conversation');
    Route::post('/supervisor/messages/send', [MessageController::class, 'sendFromSupervisor'])->name('supervisor.messages.send');
    Route::get('/api/supervisor/messages/{internId}/new', [MessageController::class, 'getNewSupervisorMessages'])->name('api.supervisor.messages.new');

    Route::get('/supervisor/attendance/status', [AttendanceController::class, 'getAttendanceStatus'])->name('supervisor.attendance.status');
    Route::post('/supervisor/attendance/mark-absent/{intern}', [AttendanceController::class, 'markAbsent'])->name('supervisor.attendance.mark-absent');
    Route::post('/supervisor/attendance/reset', [AttendanceController::class, 'resetAttendance'])->name('supervisor.attendance.reset');
});

// Intern protected routes
Route::middleware(['auth:intern'])->group(function () {
    Route::get('/intern/dashboard', [InternAuthController::class, 'dashboard'])->name('intern.dashboard');
    Route::post('/intern/profile/avatar', [InternAuthController::class, 'uploadAvatar'])->name('intern.profile.avatar');
    Route::get('/intern/attendance', [AttendanceController::class, 'showAttendance'])->name('intern.attendance');
    Route::post('/intern/attendance/mark', [AttendanceController::class, 'markAttendance'])->name('intern.attendance.mark');
    Route::get('/intern/messages', [MessageController::class, 'internMessages'])->name('intern.messages');
    Route::post('/intern/messages/send', [MessageController::class, 'sendFromIntern'])->name('intern.messages.send');
    Route::get('/api/intern/messages/new', [MessageController::class, 'getNewInternMessages'])->name('api.intern.messages.new');
    Route::get('/api/intern/message/stats', [MessageController::class, 'getInternMessageStats'])->name('api.intern.message.stats');
    Route::get('/intern/phase-submission', [InternAuthController::class, 'phaseSubmission'])->name('intern.phase-submission');

    Route::get('/intern/supervisor-messages', [MessageController::class, 'internSupervisorMessages'])->name('intern.supervisor-messages');
    Route::post('/intern/supervisor-messages/send', [MessageController::class, 'sendToSupervisor'])->name('intern.supervisor-messages.send');
    Route::get('/api/intern/supervisor-messages/new', [MessageController::class, 'getNewInternSupervisorMessages'])->name('api.intern.supervisor-messages.new');
    Route::get('/api/intern/supervisor-message/stats', [MessageController::class, 'getInternSupervisorMessageStats'])->name('api.intern.supervisor-message.stats');
    Route::get('/intern/journal', [JournalController::class, 'show'])->name('intern.journal');
    Route::post('/intern/journal/submit', [JournalController::class, 'submit'])->name('intern.journal.submit');
    Route::get('/intern/dtr', [InternAuthController::class, 'dtr'])->name('intern.dtr');
    Route::get('/intern/dtr/summary', [TimeLogController::class, 'getDTRSummary'])->name('intern.dtr.summary');
    Route::post('/intern/timein', [TimeLogController::class, 'timeIn'])->name('intern.timein');
    Route::post('/intern/timeout', [TimeLogController::class, 'timeOut'])->name('intern.timeout');
    Route::get('/intern/send-data', [InternAuthController::class, 'showSendDataForm'])->name('intern.send-data');
    Route::post('/intern/upload-docx', [InternController::class, 'uploadDocx'])->name('intern.uploadDocx');
    Route::post('/intern/submit-pre-deployment', [InternController::class, 'submitPreDeployment'])->name('intern.submit.pre-deployment');
    Route::post('/intern/submit-mid-deployment', [InternController::class, 'submitMidDeployment'])->name('intern.submit.mid-deployment');
    Route::post('/intern/submit-deployment', [InternController::class, 'submitDeployment'])->name('intern.submit.deployment');
    Route::get('/intern/select-supervisor', [InternAuthController::class, 'showSupervisorSelection'])->name('intern.select-supervisor');
    Route::post('/intern/update-supervisor', [InternAuthController::class, 'updateSupervisor'])->name('intern.update-supervisor');
});
