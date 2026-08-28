<?php
require __DIR__ . '/vendor/autoload.php';
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
