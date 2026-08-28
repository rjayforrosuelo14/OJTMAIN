<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::where('email', 'rjay@gmail.com')->first();
if ($user) {
    echo "User found: " . $user->name . "\n";
    echo "OTP Verified: " . ($user->otp_verified ? 'Yes' : 'No') . "\n";
    echo "Email Verified: " . ($user->email_verified_at ? 'Yes' : 'No') . "\n";
    echo "ID: " . $user->id . "\n";
    
    // Test password
    if (Hash::check('12345678', $user->password)) {
        echo "Password: CORRECT\n";
    } else {
        echo "Password: INCORRECT\n";
    }
} else {
    echo "User not found\n";
}
