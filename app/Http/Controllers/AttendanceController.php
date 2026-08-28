<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Intern;
use App\Models\Message;
use App\Models\TimeLog;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Show attendance page for interns.
     */
    public function showAttendance()
    {
        return view('intern-attendance');
    }

    /**
     * Mark attendance for an intern.
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $intern = Auth::guard('intern')->user();
        
        // Check if there's an active attendance session from their supervisor
        $activeAttendance = Attendance::where('supervisor_id', $intern->supervisor_id)
            ->where('is_active', true)
            ->where('created_at', '>', Carbon::now()->subMinutes(5))
            ->first();

        if (!$activeAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'No active attendance session found or session has expired. Please ask your supervisor to release attendance again.'
            ], 400);
        }

        // Check if already attended
        if ($intern->hasAttended()) {
            return response()->json([
                'success' => false,
                'message' => 'You have already marked your attendance.'
            ], 400);
        }

        // Mark attendance and create today's time log for DTR.
        $intern->markPresent($request->notes);

        $today = now('Asia/Manila')->toDateString();
        $timeLog = TimeLog::firstOrCreate(
            ['intern_id' => $intern->id, 'date' => $today],
            ['time_in' => now('Asia/Manila')->toTimeString()]
        );

        if (!$timeLog->time_in) {
            $timeLog->update(['time_in' => now('Asia/Manila')->toTimeString()]);
        }

        // Send notification to supervisor
        Message::create([
            'sender_id' => $intern->id,
            'receiver_id' => $activeAttendance->supervisor_id,
            'sender_type' => 'intern',
            'receiver_type' => 'supervisor',
            'content' => "{$intern->first_name} {$intern->last_name} has marked attendance.",
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully!'
        ]);
    }

    /**
     * Get attendance status for supervisor monitoring.
     */
    public function getAttendanceStatus(Request $request)
    {
        $supervisor = Auth::guard('supervisor')->user();
        
        $interns = Intern::where('supervisor_id', $supervisor->id)
            ->where('status', 'accepted')
            ->select([
                'id', 'first_name', 'last_name', 'section',
                'attendance_status', 'attendance_time', 'attendance_notes'
            ])
            ->get();

        return response()->json([
            'interns' => $interns,
            'total' => $interns->count(),
            'present' => $interns->where('attendance_status', 'present')->count(),
            'absent' => $interns->where('attendance_status', 'absent')->count(),
            'not_noticed' => $interns->where('attendance_status', 'not_released')->count()
        ]);
    }

    /**
     * Mark intern as absent manually.
     */
    public function markAbsent(Request $request, $internId)
    {
        $supervisor = Auth::guard('supervisor')->user();
        
        $intern = Intern::where('id', $internId)
            ->where('supervisor_id', $supervisor->id)
            ->first();

        if (!$intern) {
            return response()->json([
                'success' => false,
                'message' => 'Intern not found.'
            ], 404);
        }

        $intern->markAbsent($request->notes ?? 'Marked absent by supervisor');

        return response()->json([
            'success' => true,
            'message' => 'Intern marked as absent.'
        ]);
    }

    /**
     * Reset attendance for all interns.
     */
    public function resetAttendance(Request $request)
    {
        $supervisor = Auth::guard('supervisor')->user();
        
        Intern::where('supervisor_id', $supervisor->id)
            ->update([
                'attendance_status' => 'not_released',
                'attendance_time' => null,
                'attendance_notes' => null
            ]);

        // Deactivate all active attendances
        Attendance::where('supervisor_id', $supervisor->id)
            ->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance reset successfully.'
        ]);
    }
}
