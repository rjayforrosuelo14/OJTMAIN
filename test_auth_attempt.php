<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Attempt to login with the test credentials
$credentials = [
    'email' => 'rjay@gmail.com',
    'password' => '12345678'
];

echo "Testing login with credentials:\n";
echo "Email: " . $credentials['email'] . "\n";
echo "Password: " . $credentials['password'] . "\n\n";

// Find the user
$user = User::where('email', $credentials['email'])->first();
if (!$user) {
    echo "User not found in database\n";
    exit;
}

echo "User found: " . $user->name . "\n";
echo "User ID: " . $user->id . "\n";
echo "OTP Verified: " . ($user->otp_verified ? "Yes" : "No") . "\n";
echo "Email Verified: " . ($user->email_verified_at ? "Yes" : "No") . "\n\n";

// Test password hash
$isPasswordCorrect = Hash::check($credentials['password'], $user->password);
echo "Password Check: " . ($isPasswordCorrect ? "CORRECT" : "INCORRECT") . "\n\n";

// Test Auth::attempt()
$attempt = Auth::attempt($credentials);
echo "Auth::attempt() result: " . ($attempt ? "SUCCESS - Login would work" : "FAILED - Login will fail") . "\n";

if ($attempt) {
    echo "Current authenticated user: " . Auth::user()->email . "\n";
    Auth::logout();
}
