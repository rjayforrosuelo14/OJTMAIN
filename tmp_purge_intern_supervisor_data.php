<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use App\Models\Intern;
use App\Models\Supervisor;

DB::statement('SET FOREIGN_KEY_CHECKS=0');

// Remove all intern- and supervisor-related messages
$messagesDeleted = DB::table('messages')
    ->whereIn('sender_type', ['intern', 'supervisor'])
    ->orWhereIn('receiver_type', ['intern', 'supervisor'])
    ->delete();

// Remove all supervisors and dependent supervisor records
$supervisorsDeleted = Supervisor::query()->delete();

// Remove any remaining attendance records (should cascade from supervisors)
$attendancesDeleted = Attendance::query()->delete();

// Remove all interns and dependent intern records
$internsDeleted = Intern::query()->delete();

DB::statement('SET FOREIGN_KEY_CHECKS=1');

echo "Deleted records:\n";
echo "  messages: {$messagesDeleted}\n";
echo "  attendances: {$attendancesDeleted}\n";
echo "  supervisors: {$supervisorsDeleted}\n";
echo "  interns: {$internsDeleted}\n";
