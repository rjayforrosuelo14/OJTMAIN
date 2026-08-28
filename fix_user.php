<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::where('email', 'rjay@gmail.com')->first();
if ($user) {
    $user->update([
        'otp_verified' => true,
        'email_verified_at' => now()
    ]);
    echo "User updated successfully!\n";
    echo "User: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "OTP Verified: Yes\n";
    echo "Email Verified: Yes\n";
} else {
    echo "User not found\n";
}
