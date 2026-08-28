<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeLog;
use App\Models\Intern;
use Carbon\Carbon;

class TimeLogController extends Controller
{
    /**
     * Handle intern time in (only once per day).
     */
    public function timeIn()
    {
        $intern = Auth::guard('intern')->user();
        $today = now('Asia/Manila')->toDateString();

        $activeLog = TimeLog::where('intern_id', $intern->id)
            ->where('date', $today)
            ->whereNull('time_out')
            ->first();

        if ($activeLog) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have an active time-in for today. Please time out first.'
                ]);
            }
            return back()->with('error', 'You already have an active time-in for today. Please time out first.');
        }

        TimeLog::create([
            'intern_id' => $intern->id,
            'date' => $today,
            'time_in' => now('Asia/Manila')->toTimeString(),
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Time In recorded successfully!',
                'time' => now('Asia/Manila')->toTimeString(),
            ]);
        }

        return back()->with('success', '✅ Time In recorded!');
    }

    /**
     * Handle intern time out (manual or automatic at 5:00 PM).
     */
    public function timeOut()
    {
        $intern = Auth::guard('intern')->user();
        $today = now('Asia/Manila')->toDateString();

        $log = TimeLog::where('intern_id', $intern->id)
            ->where('date', $today)
            ->whereNull('time_out')
            ->first();

        if (!$log) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active time-in found for today. Please time in first.'
                ]);
            }
            return back()->with('error', '⚠️ No active time-in found for today. Please time in first.');
        }

        $now = now('Asia/Manila');

        // Record the actual clock-out time so afternoon in/out works naturally.
        $log->update([
            'time_out' => $now->toTimeString(),
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Time Out recorded successfully!',
                'time' => $log->time_out,
            ]);
        }

        return back()->with('success', '🕔 Time Out recorded!');
    }

    /**
     * Admin view of DTR as printable Blade table (not download).
     */
    public function showDTR($id)
    {
        $intern = Intern::findOrFail($id);
        $logs = TimeLog::where('intern_id', $id)
            ->orderBy('date', 'asc')
            ->get();

        return view('dtr', compact('intern', 'logs'));
    }

    /**
     * Get real-time DTR data for the current month
     */
    public function getRealTimeDTR()
    {
        $intern = Auth::guard('intern')->user();
        $currentMonth = now('Asia/Manila')->format('Y-m');
        
        $logs = TimeLog::where('intern_id', $intern->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->orderBy('date', 'desc')
            ->get();

        $totalHours = 0;
        $totalDays = 0;
        $currentDayLog = null;

        foreach ($logs as $log) {
            if ($log->time_in && $log->time_out) {
                $timeIn = Carbon::parse($log->date . ' ' . $log->time_in, 'Asia/Manila');
                $timeOut = Carbon::parse($log->date . ' ' . $log->time_out, 'Asia/Manila');
                $totalHours += $timeIn->diffInHours($timeOut);
                $totalDays++;
            }
            
            // Get current day's log
            if ($log->date === now('Asia/Manila')->toDateString()) {
                $currentDayLog = $log;
            }
        }

        return response()->json([
            'total_hours' => $totalHours,
            'total_days' => $totalDays,
            'current_day_log' => $currentDayLog,
            'current_time' => now('Asia/Manila')->format('H:i:s'),
            'is_working_hours' => now('Asia/Manila')->between(
                Carbon::createFromTime(8, 0, 0, 'Asia/Manila'),
                Carbon::createFromTime(17, 0, 0, 'Asia/Manila')
            )
        ]);
    }

    /**
     * Get DTR summary for dashboard
     */
    public function getDTRSummary()
    {
        $intern = Auth::guard('intern')->user();
        $today = now('Asia/Manila')->toDateString();
        $currentMonth = now('Asia/Manila')->format('Y-m');
        
        $todayLogs = TimeLog::where('intern_id', $intern->id)
            ->where('date', $today)
            ->orderBy('time_in', 'asc')
            ->get();

        $activeLog = $todayLogs->firstWhere('time_out', null);
        $latestLog = $todayLogs->last();

        $monthlyLogs = TimeLog::where('intern_id', $intern->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->get();

        $monthlyMinutes = 0;
        $monthlyDays = 0;
        $totalUnderMinutes = 0;

        foreach ($monthlyLogs as $log) {
            if ($log->time_in && $log->time_out) {
                $timeIn = Carbon::parse($log->date . ' ' . $log->time_in, 'Asia/Manila');
                $timeOut = Carbon::parse($log->date . ' ' . $log->time_out, 'Asia/Manila');
                $durationMinutes = $timeIn->diffInMinutes($timeOut);
                $monthlyMinutes += $durationMinutes;
                $monthlyDays++;

                if ($durationMinutes < 480) {
                    $totalUnderMinutes += 480 - $durationMinutes;
                }
            }
        }

        $todayStatus = 'not_started';
        $todayTimeIn = null;
        $todayTimeOut = null;

        if ($activeLog) {
            $todayStatus = 'working';
            $todayTimeIn = $activeLog->time_in;
            $todayTimeOut = $activeLog->time_out;
        } elseif ($todayLogs->isNotEmpty()) {
            $todayStatus = 'ready_for_next_session';
            $todayTimeIn = $latestLog?->time_in;
            $todayTimeOut = $latestLog?->time_out;
        }

        $monthlyHours = round($monthlyMinutes / 60, 2);
        $totalUnderHours = round($totalUnderMinutes / 60, 2);

        return response()->json([
            'today_status' => $todayStatus,
            'today_time_in' => $todayTimeIn,
            'today_time_out' => $todayTimeOut,
            'monthly_hours' => $monthlyHours,
            'monthly_days' => $monthlyDays,
            'total_under_time_hours' => $totalUnderHours,
            'target_hours' => 486,
            'progress_percent' => min(100, round(($monthlyHours / 486) * 100))
        ]);
    }
}
