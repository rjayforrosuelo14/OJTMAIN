<?php
// Test authentication
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$container = $app->make(Illuminate\Contracts\Container\Container::class);
$app->make(Illuminate\Contracts\Http\Kernel::class)->bootstrap();

// Test Auth
$credentials = [
    'email' => 'rjay@gmail.com',
    'password' => '12345678'
];

echo "Testing authentication with credentials:\n";
echo "Email: " . $credentials['email'] . "\n";
echo "Password: " . $credentials['password'] . "\n\n";

// Attempt auth
if (Illuminate\Support\Facades\Auth::attempt($credentials)) {
    echo "Authentication: SUCCESS ✓\n";
    echo "Authenticated user: " . Illuminate\Support\Facades\Auth::user()->email . "\n";
} else {
    echo "Authentication: FAILED ✗\n";
    
    // Debug: Check if user exists
    $user = App\Models\User::where('email', 'rjay@gmail.com')->first();
    if ($user) {
        echo "User exists: YES\n";
        echo "User ID: " . $user->id . "\n";
        echo "User password field is set: " . (!empty($user->password) ? "YES" : "NO") . "\n";
        
        // Test password_verify directly
        if (password_verify($credentials['password'], $user->password)) {
            echo "Password verification: MATCHES ✓\n";
        } else {
            echo "Password verification: DOES NOT MATCH ✗\n";
        }
    } else {
        echo "User exists: NO\n";
    }
}
?>
