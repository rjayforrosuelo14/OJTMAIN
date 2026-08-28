<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Direct SQL update to verify user
$updated = DB::table('users')
    ->where('email', 'rjay@gmail.com')
    ->update([
        'otp_verified' => 1,
        'email_verified_at' => now()
    ]);

echo "Update result: " . ($updated ? "Success - $updated row(s) updated\n" : "Failed\n");

// Verify the update
$user = \App\Models\User::where('email', 'rjay@gmail.com')->first();
if ($user) {
    echo "User: " . $user->name . "\n";
    echo "OTP Verified: " . ($user->otp_verified ? "Yes" : "No") . "\n";
    echo "Email Verified: " . ($user->email_verified_at ? "Yes" : "No") . "\n";
}
