<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'jamesnapalya79@gmail.com';
$password = 'James@2025*';
$user = User::where('email', $email)->first();
if (!$user) {
    echo "User not found\n";
    exit(0);
}
echo "Found user: {$user->id} | {$user->name} | {$user->email}\n";
if (Hash::check($password, $user->password)) {
    echo "Password match\n";
} else {
    echo "Password mismatch\n";
}
