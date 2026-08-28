<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Intern;
use App\Models\Supervisor;

$email = 'jamesnapalya79@gmail.com';
$intern = Intern::where('email', $email)->first();
$supervisor = Supervisor::where('email', $email)->first();

if ($intern) {
    echo "INTERN: {$intern->id}|{$intern->first_name} {$intern->last_name}|{$intern->email}|status={$intern->status}\n";
} else {
    echo "INTERN: none\n";
}

if ($supervisor) {
    echo "SUPERVISOR: {$supervisor->id}|{$supervisor->name}|{$supervisor->email}|accepted={$supervisor->is_accepted}\n";
} else {
    echo "SUPERVISOR: none\n";
}
