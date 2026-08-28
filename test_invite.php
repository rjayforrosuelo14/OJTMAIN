<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use Illuminate\Support\Facades\Crypt;

// Test encryption
$userId = 1;
$payload = [
    'invited_by' => $userId,
    'exp' => time() + (12 * 3600),
];

try {
    $token = Crypt::encryptString(json_encode($payload));
    $loginPath = '/interns/login';
    $fullUrl = 'http://127.0.0.1:9002' . $loginPath . '?invite=' . urlencode($token);
    
    echo "Success!\n";
    echo "URL: " . $fullUrl . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
