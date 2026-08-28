<?php
require 'vendor/autoload.php';

$pdo = new PDO('sqlite:database/database.sqlite');

// Get table structure
$stmt = $pdo->query("PRAGMA table_info(users);");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Users table structure:\n";
echo "=======================\n";
foreach ($columns as $col) {
    echo "Column: {$col['name']}, Type: {$col['type']}, NotNull: {$col['notnull']}, PK: {$col['pk']}\n";
}

// Check user record
echo "\n\nUser record:\n";
echo "=======================\n";
$stmt = $pdo->prepare('SELECT id, email, password, otp_verified, email_verified_at FROM users WHERE email = ?');
$stmt->execute(['rjay@gmail.com']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "ID: {$user['id']}\n";
    echo "Email: {$user['email']}\n";
    echo "Password length: " . strlen($user['password']) . "\n";
    echo "OTP Verified: {$user['otp_verified']}\n";
    echo "Email Verified At: {$user['email_verified_at']}\n";
} else {
    echo "User not found\n";
}
?>
