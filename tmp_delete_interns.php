<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Intern;

$emails = [
    'sj@gmail.com',
    'kh@gmail.com',
    'g@gmail.com',
    'y@gmail.com',
    'f@gmail.com',
    'l@gmail.com',
    'q@gmail.com',
    'v@gmail.com',
    'e@gmail.com',
    'jamesnapalya79@gmail.com',
];

$interns = Intern::whereIn('email', $emails)->get();
if ($interns->isEmpty()) {
    echo "No matching intern records found.\n";
    exit(0);
}

foreach ($interns as $intern) {
    echo sprintf("Found: %d | %s %s | %s | status=%s | attendance_status=%s | supervisor_id=%s\n",
        $intern->id,
        $intern->first_name,
        $intern->last_name,
        $intern->email,
        $intern->status,
        $intern->attendance_status,
        $intern->supervisor_id
    );
}

$deleted = Intern::whereIn('email', $emails)->delete();
echo "Deleted: {$deleted} record(s)\n";
