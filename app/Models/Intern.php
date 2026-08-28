<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intern extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
        'avatar',
        'first_name',
        'last_name',
        'course',
        'section',
        'phone',
        'company_name',
        'company_phone',
        'company_address',
        'supervisor_name',
        'supervisor_position',
        'supervisor_email',
        'application_letter',
        'parents_waiver',
        'acceptance_letter',
        'status',
        'attendance_released_at',
        'attendance_status',
        'attendance_time',
        'attendance_notes',
        'supervisor_id',
        // Pre-Enrollment Phase fields
        'pre_enrollment_status',
        'pre_enrollment_accepted_at',
        // Pre-Deployment Phase fields
        'resume',
        'medical_certificate',
        'insurance',
        'pre_deployment_status',
        'pre_deployment_accepted_at',
        'memorandum_of_agreement',
        'internship_contract',
        'mid_deployment_status',
        'mid_deployment_accepted_at',
        'recommendation_letter',
        'endorsement_letter',
        'deployment_status',
        'deployment_accepted_at',
        'current_phase',
        'invited_by_user_id',
        // OTP fields
        'otp_code',
        'otp_expires_at',
        'otp_verified',
    ];

    protected $casts = [
        'attendance_released_at' => 'datetime',
        'attendance_time' => 'datetime',
        'pre_enrollment_accepted_at' => 'datetime',
        'pre_deployment_accepted_at' => 'datetime',
        'mid_deployment_accepted_at' => 'datetime',
        'deployment_accepted_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'otp_verified' => 'boolean',
    ];

    protected $hidden = ['password'];

    /**
     * Get the time logs associated with the intern.
     */
    public function timeLogs(): HasMany
    {
        return $this->hasMany(TimeLog::class);
    }

    /**
     * Get the journals written by the intern.
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    /**
     * Get the documents submitted by the intern.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the grade submissions for the intern.
     */
    public function gradeSubmissions()
    {
        return $this->hasMany(GradeSubmission::class);
    }

    /**
     * Get the supervisor for the intern.
     */
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    /**
     * Mark attendance as present.
     */
    public function markPresent(string $notes = null): void
    {
        $this->update([
            'attendance_status' => 'present',
            'attendance_time' => now(),
            'attendance_notes' => $notes
        ]);
    }

    /**
     * Mark attendance as absent.
     */
    public function markAbsent(string $notes = null): void
    {
        $this->update([
            'attendance_status' => 'absent',
            'attendance_time' => now(),
            'attendance_notes' => $notes
        ]);
    }

    /**
     * Reset attendance status.
     */
    public function resetAttendance(): void
    {
        $this->update([
            'attendance_status' => 'not_released',
            'attendance_time' => null,
            'attendance_notes' => null
        ]);
    }

    /**
     * Check if attendance is released.
     */
    public function isAttendanceReleased(): bool
    {
        return $this->attendance_status !== 'not_released';
    }

    /**
     * Check if intern has attended.
     */
    public function hasAttended(): bool
    {
        return $this->attendance_status === 'present';
    }

    /**
     * Check if intern can proceed to next phase
     */
    public function canProceedToNextPhase(): bool
    {
        switch ($this->current_phase) {
            case 'pre_enrollment':
                return $this->pre_enrollment_status === 'accepted';
            case 'pre_deployment':
                return $this->pre_deployment_status === 'accepted';
            case 'mid_deployment':
                return $this->mid_deployment_status === 'accepted';
            case 'deployment':
                return $this->deployment_status === 'accepted';
            default:
                return false;
        }
    }

    /**
     * Check if intern has completed all phases.
     *
     * FIX: previously this only checked `current_phase === 'completed'`,
     * but nothing in the codebase reliably advances `current_phase` to
     * 'completed' once the deployment phase is accepted. That caused
     * fully-cleared interns to be redirected back to phase-submission
     * instead of the dashboard after login.
     *
     * Now it also recognizes an accepted deployment phase as "complete",
     * and self-heals the `current_phase` column so future checks are fast
     * and consistent.
     */
    public function hasCompletedAllPhases(): bool
    {
        if ($this->current_phase === 'deployment'
            && $this->deployment_status === 'accepted') {
            $this->update(['current_phase' => 'completed']);
        }

        return $this->current_phase === 'completed';
    }

    /**
     * Get current phase status
     */
    public function getCurrentPhaseStatus(): string
    {
        switch ($this->current_phase) {
            case 'pre_enrollment':
                return $this->pre_enrollment_status;
            case 'pre_deployment':
                return $this->pre_deployment_status;
            case 'mid_deployment':
                return $this->mid_deployment_status;
            case 'deployment':
                return $this->deployment_status;
            default:
                return 'completed';
        }
    }

    /**
     * Check if intern can access dashboard
     */
    public function canAccessDashboard(): bool
    {
        return $this->status === 'accepted' && $this->hasCompletedAllPhases();
    }

    /**
     * Check if intern has submitted journal this week
     */
    public function hasSubmittedJournalThisWeek(): bool
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        return $this->journals()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->exists();
    }

    /**
     * Check if intern has marked attendance for today
     */
    public function hasMarkedAttendanceToday(): bool
    {
        return $this->attendance_status === 'present' && 
               $this->attendance_time && 
               $this->attendance_time->isToday();
    }

    /**
     * Check if intern should receive attendance notification
     */
    public function shouldReceiveAttendanceNotification(): bool
    {
        // Only notify if attendance is released but not yet marked
        return $this->isAttendanceReleased() && 
               !$this->hasMarkedAttendanceToday() &&
               $this->attendance_status !== 'present';
    }

    /**
     * Get total monthly hours from time logs
     */
    public function getTotalMonthlyHours(): float
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $logs = $this->timeLogs()
            ->whereBetween('date', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
            ->get();

        $totalSeconds = 0;

        foreach ($logs as $log) {
            $in = $log->time_in ? \Carbon\Carbon::parse($log->date . ' ' . $log->time_in, 'Asia/Manila') : null;
            $out = $log->time_out ? \Carbon\Carbon::parse($log->date . ' ' . $log->time_out, 'Asia/Manila') : null;

            if ($in && !$out) {
                $out = \Carbon\Carbon::parse($log->date . ' 17:00:00', 'Asia/Manila');
            }

            if ($in && $out) {
                $totalSeconds += $in->diffInSeconds($out);
            }
        }

        return round($totalSeconds / 3600, 2);
    }
}