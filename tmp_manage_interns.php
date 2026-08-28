<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Intern;

$emails = [
    'j@gmail.com',
    'en@gmail.com',
    'i@gmail.com',
    'z@gmail.com',
    'a@gmail.com',
    'jkr.grande@gmail.com',
];

$interns = Intern::whereIn('email', $emails)->get();
foreach ($interns as $intern) {
    echo $intern->id . ' | ' . $intern->first_name . ' ' . $intern->last_name . ' | ' . $intern->email . PHP_EOL;
}
echo 'COUNT: ' . $interns->count() . PHP_EOL;

if ($interns->isNotEmpty()) {
    $deleted = Intern::whereIn('email', $emails)->delete();
    echo 'DELETED: ' . $deleted . ' record(s)' . PHP_EOL;
} else {
    echo 'No matching records to delete.' . PHP_EOL;
}
