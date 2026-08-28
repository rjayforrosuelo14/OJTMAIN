<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Supervisor;
use App\Models\Intern;
use App\Models\Message;
use App\Models\Attendance;
use App\Models\TimeLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SupervisorController extends Controller
{
    // Show supervisor login form
    public function showLoginForm()
    {
        return view('supervisor-login');
    }

    // Handle supervisor login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['email'] = strtolower(trim($credentials['email']));

        try {
            $supervisor = Supervisor::where('email', $credentials['email'])->first();
        } catch (QueryException $e) {
            return back()->with('error', 'Unable to connect to the database. Please make sure MySQL is running and try again.');
        }

        if (! $supervisor) {
            return back()->with('error', 'Invalid credentials.');
        }

        if (! $supervisor->is_accepted) {
            return back()->with('error', 'Your account is pending approval by the admin.');
        }

        try {
            if (Auth::guard('supervisor')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('supervisor.dashboard');
            }
        } catch (QueryException $e) {
            return back()->with('error', 'Unable to connect to the database. Please make sure MySQL is running and try again.');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    // Show supervisor registration form
    public function showRegisterForm()
    {
        return view('supervisor-register');
    }

    // Handle supervisor registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supervisors,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = strtolower(trim($request->email));

        if (Intern::where('email', $email)->exists() || User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'This email is already registered as an intern or admin.'])->withInput();
        }

        \App\Models\Supervisor::create([
            'name' => $request->name,
            'email' => $email,
            'password' => \Hash::make($request->password),
            'is_accepted' => false,
        ]);

        return redirect()->route('supervisor.login')->with('error', 'Registration successful! Please wait for admin approval before logging in.');
    }

    // List all supervisors for admin
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Supervisor::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        $supervisors = $query->orderBy('name')->get();
        return view('supervisor', compact('supervisors', 'search'));
    }

    /**
     * Show supervisor profile and avatar upload form.
     */
    public function profile()
    {
        return view('supervisor-profile');
    }

    /**
    * Handle avatar upload and store under storage/app/public/supervisor profile/
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:5120', // max 5MB
        ]);

        $supervisor = Auth::guard('supervisor')->user();
        if (! $supervisor) {
            return redirect()->route('supervisor.login')->with('error', 'Not authenticated.');
        }

        $file = $request->file('avatar');
        $ext = $file->getClientOriginalExtension();
        $filename = 'supervisor_' . $supervisor->id . '.' . $ext;

        // Store the image in the public folder served by the profile and header.
        $directory = public_path('storage/supervisor profile');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $file->move($directory, $filename);
        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        // Optionally remove other existing supervisor images with different extensions
        $allowed = ['png','jpg','jpeg','gif','webp'];
        foreach ($allowed as $e) {
            $candidate = $directory . DIRECTORY_SEPARATOR . 'supervisor_' . $supervisor->id . '.' . $e;
            if ($candidate !== $path && file_exists($candidate)) {
                unlink($candidate);
            }
        }

        return redirect()->route('supervisor.profile')->with('success', 'Profile image uploaded.');
    }

    // Update supervisor (admin)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:supervisors,email,' . $id,
        ]);

        $email = strtolower(trim($request->email));

        if (Intern::where('email', $email)->exists() || User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'This email is already registered as an intern or admin.'])->withInput();
        }

        $supervisor = Supervisor::findOrFail($id);
        $supervisor->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->route('supervisors')->with('success', 'Supervisor updated successfully.');
    }

    // Delete supervisor (admin)
    public function delete($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $supervisor->delete();
        return redirect()->route('supervisors')->with('success', 'Supervisor deleted successfully.');
    }

    // Accept supervisor (admin)
    public function accept($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $supervisor->is_accepted = true;
        $supervisor->save();
        return redirect()->route('supervisors')->with('success', 'Supervisor accepted.');
    }

    // Reject supervisor (admin)
    public function reject($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $supervisor->delete();
        return redirect()->route('supervisors')->with('success', 'Supervisor rejected.');
    }

    // Supervisor dashboard
    public function dashboard()
    {
        $supervisor = auth()->guard('supervisor')->user();
        $interns = Intern::where('supervisor_id', $supervisor->id)
            ->where('status', 'accepted')
            ->where('email', '!=', $supervisor->email)
            ->get();
            
        // Get attendance statistics
        $totalInterns = $interns->count();
        $presentCount = $interns->where('attendance_status', 'present')->count();
        $absentCount = $interns->where('attendance_status', 'absent')->count();
        $notNoticedCount = $interns->where('attendance_status', 'not_released')->count();
        
        // Get active attendance session
        $activeAttendance = Attendance::where('supervisor_id', $supervisor->id)
            ->where('is_active', true)
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();
        
        // Get incoming (unconnected) interns - limit to 10
        $incomingInterns = Intern::whereNull('supervisor_id')
            ->where('status', 'accepted')
            ->limit(10)
            ->get();
            
        return view('supervisor-dashboard', compact(
            'supervisor', 
            'interns', 
            'totalInterns', 
            'presentCount', 
            'absentCount', 
            'notNoticedCount',
            'activeAttendance',
            'incomingInterns'
        ));
    }

    // Supervisor releases attendance for connected interns only
    public function releaseAttendance()
    {
        $supervisor = auth()->guard('supervisor')->user();
        
        // Get only interns connected to this supervisor
        $connectedInterns = Intern::where('supervisor_id', $supervisor->id)
            ->where('status', 'accepted')
            ->where('email', '!=', $supervisor->email)
            ->get();
            
        if ($connectedInterns->isEmpty()) {
            return redirect()->route('supervisor.dashboard')
                ->with('error', 'No interns are connected to you.');
        }
        
        $now = now();
        
        // Deactivate any existing active attendances for this supervisor
        Attendance::where('supervisor_id', $supervisor->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        // Create new attendance session
        Attendance::createForSupervisor($supervisor->id);
        
        foreach ($connectedInterns as $intern) {
            $intern->update([
                'attendance_status' => 'released',
                'attendance_released_at' => $now
            ]);
            
            // Send notification to intern
            Message::create([
                'sender_id' => $supervisor->id,
                'receiver_id' => $intern->id,
                'sender_type' => 'supervisor',
                'receiver_type' => 'intern',
                'content' => 'Time In is now available! Click "Time In" to mark your attendance. (Expires in 5 minutes)',
                'is_read' => false,
            ]);
        }
        
        return redirect()->route('supervisor.dashboard')
            ->with('success', 'Time In released for ' . $connectedInterns->count() . ' connected interns. (Expires in 5 minutes)');
    }

    // Mark intern as present/absent
    public function markAttendance(Request $request, $internId)
    {
        $supervisor = auth()->guard('supervisor')->user();
        $intern = Intern::findOrFail($internId);

        // Verify the intern belongs to this supervisor
        if ($intern->supervisor_id !== $supervisor->id) {
            return back()->with('error', 'You can only mark attendance for your connected interns.');
        }

        $status = $request->input('status'); // 'present' or 'absent'
        
        if (!in_array($status, ['present', 'absent'])) {
            return back()->with('error', 'Invalid status.');
        }

        $attendanceTime = now('Asia/Manila');

        $intern->update([
            'attendance_status' => $status,
            'attendance_time' => $attendanceTime,
        ]);

        if ($status === 'present') {
            $today = $attendanceTime->toDateString();
            $timeLog = TimeLog::firstOrCreate(
                ['intern_id' => $intern->id, 'date' => $today],
                ['time_in' => $attendanceTime->toTimeString()]
            );

            if (!$timeLog->time_in) {
                $timeLog->update(['time_in' => $attendanceTime->toTimeString()]);
            }
        }

        return back()->with('success', ucfirst($intern->first_name) . ' marked as ' . $status . '.');
    }

    // Select incoming intern
    public function selectIncomingIntern(Request $request, $internId)
    {
        $supervisor = auth()->guard('supervisor')->user();
        $intern = Intern::findOrFail($internId);

        // Verify the intern is not yet assigned
        if ($intern->supervisor_id !== null) {
            return back()->with('error', 'This intern is already connected to another supervisor.');
        }

        // Verify intern status is accepted
        if ($intern->status !== 'accepted') {
            return back()->with('error', 'This intern cannot be assigned at this time.');
        }

        // Assign intern to supervisor
        $intern->update([
            'supervisor_id' => $supervisor->id,
            'attendance_status' => 'pending',
            'attendance_time' => now(),
        ]);

        // Send notification to intern
        Message::create([
            'sender_id' => $supervisor->id,
            'receiver_id' => $intern->id,
            'sender_type' => 'supervisor',
            'receiver_type' => 'intern',
            'content' => 'You have been assigned to ' . $supervisor->name . ' as your supervisor.',
            'is_read' => false,
        ]);

        return back()->with('success', ucfirst($intern->first_name) . ' ' . $intern->last_name . ' has been added to your team.');
    }

    // Supervisor logout
    public function logout()
    {
        \Auth::guard('supervisor')->logout();
        return redirect()->route('supervisor.login');
    }
} 