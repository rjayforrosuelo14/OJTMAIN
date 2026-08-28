<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supervisor;
use App\Models\Intern;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Show form to connect interns to a supervisor
    public function showConnectInternsForm($supervisorId)
    {
        $supervisor = Supervisor::findOrFail($supervisorId);
        $interns = Intern::with('supervisor')->get();
        return view('admin.connect-interns', compact('supervisor', 'interns'));
    }

    // Save intern-supervisor connections
    public function connectInterns(Request $request, $supervisorId)
    {
        $supervisor = Supervisor::findOrFail($supervisorId);
        $internIds = $request->input('intern_ids', []);
        // Disconnect all interns currently connected to this supervisor
        Intern::where('supervisor_id', $supervisor->id)->whereNotIn('id', $internIds)->update(['supervisor_id' => null]);
        // Connect selected interns
        Intern::whereIn('id', $internIds)->update(['supervisor_id' => $supervisor->id]);
        return redirect()->route('supervisors')->with('success', 'Intern(s) connected successfully!');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:5120'],
        ]);

        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $file = $request->file('avatar');
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $filename = 'admin_' . $user->id . '.' . $extension;

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $file->storeAs('admins', $filename, 'public');
        $user->avatar = $path;
        $user->save();

        return back()->with('success', 'Profile image uploaded successfully.');
    }
} 