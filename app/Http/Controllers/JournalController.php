<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use App\Models\Intern;

class JournalController extends Controller
{
    /**
     * Show journal form to the logged-in intern.
     */
    public function show()
    {
        $intern = Auth::guard('intern')->user();

        $submittedJournals = Document::where('intern_id', $intern->id)
            ->where('type', 'journal')
            ->pluck('description')
            ->toArray();

        return view('journal', compact('submittedJournals'));
    }

    /**
     * Handle journal .docx file upload by intern.
     */
    public function submit(Request $request)
    {
        // Allow only on Fridays
        if (now()->format('l') !== 'Friday') {
            return back()->with('error', 'You can only upload your journal every Friday.');
        }

        $request->validate([
            'journal_file' => 'required|file|mimes:docx|max:2048', // 2MB max
        ]);

        $intern = Auth::guard('intern')->user();

        // Prevent multiple uploads on the same Friday
        $alreadyUploaded = Document::where('intern_id', $intern->id)
            ->where('type', 'journal')
            ->whereDate('submitted_at', now()->toDateString())
            ->exists();

        if ($alreadyUploaded) {
            return back()->with('error', 'You have already uploaded a journal today.');
        }

        // Store the uploaded file
        $file = $request->file('journal_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('journals', $filename, 'public');

        // Description: "Journal - Week ending July 5, 2025"
        $description = 'Journal - Week ending ' . now()->format('F j, Y');

        // Save in documents table
        Document::create([
            'intern_id'    => $intern->id,
            'type'         => 'journal',
            'path'         => 'storage/' . $path,
            'filename'     => $filename,
            'submitted_at' => now(),
            'description'  => $description,
        ]);

        return redirect()->route('intern.journal')->with('success', 'Journal uploaded successfully for the week.');
    }

    /**
     * Admin view of an intern’s journal entries.
     */
    public function adminView($id)
    {
        $intern = Intern::findOrFail($id);

        $journals = Document::where('intern_id', $intern->id)
            ->where('type', 'journal')
            ->orderBy('submitted_at', 'asc')
            ->get();

        return view('admin_journal', compact('intern', 'journals'));
    }
}
