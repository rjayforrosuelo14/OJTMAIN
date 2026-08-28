<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'supervisor_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the supervisor that created this attendance.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class);
    }

    /**
     * Check if the attendance session is expired (5 minutes).
     */
    public function isExpired(): bool
    {
        return $this->created_at->addMinutes(5)->isPast();
    }

    /**
     * Check if the attendance session is valid (not expired and active).
     */
    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * Create a new attendance session for a supervisor.
     */
    public static function createForSupervisor(int $supervisorId): self
    {
        return static::create([
            'supervisor_id' => $supervisorId,
            'is_active' => true
        ]);
    }

    /**
     * Deactivate expired attendances.
     */
    public static function deactivateExpired(): void
    {
        static::where('created_at', '<', Carbon::now()->subMinutes(5))
            ->update(['is_active' => false]);
    }
}
