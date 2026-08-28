<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Intern;
use App\Models\Supervisor;

$email = 'Rjayforsuelo@gmail.com';

$intern = Intern::where('email', $email)->first();
$supervisor = Supervisor::where('email', $email)->first();

if ($intern) {
    echo "Intern found: {$intern->id} | {$intern->first_name} {$intern->last_name} | {$intern->email} | status={$intern->status} | supervisor_id={$intern->supervisor_id}\n";
} else {
    echo "Intern not found\n";
}

if ($supervisor) {
    echo "Supervisor found: {$supervisor->id} | {$supervisor->name} | {$supervisor->email} | is_accepted={$supervisor->is_accepted}\n";
} else {
    echo "Supervisor not found\n";
}
