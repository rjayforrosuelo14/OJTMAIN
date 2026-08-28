<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Supervisor;
use App\Models\Intern;

$supervisor = Supervisor::where('name', 'like', '%rjay%')->orWhere('email', 'like', '%rjay%')->first();
if (!$supervisor) {
    echo "Supervisor not found\n";
    exit(1);
}

echo "Supervisor: {$supervisor->id} | {$supervisor->name} | {$supervisor->email}\n";
$interns = Intern::where('supervisor_id', $supervisor->id)->get();
foreach ($interns as $intern) {
    echo implode(' | ', [
        $intern->id,
        $intern->first_name . ' ' . $intern->last_name,
        $intern->email,
        $intern->status,
        $intern->attendance_status,
        'supervisor_id='.$intern->supervisor_id,
    ]) . "\n";
}
 echo 'Count: ' . $interns->count() . "\n";
