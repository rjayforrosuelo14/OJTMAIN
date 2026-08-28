<?php
require 'vendor/autoload.php';

// Create a new hash for password 12345678
$password = '12345678';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['rounds' => 12]);

echo "New password hash for '12345678':\n";
echo $hashedPassword . "\n\n";

// Update the user in database
$pdo = new PDO('sqlite:database/database.sqlite');
$stmt = $pdo->prepare('UPDATE users SET password = ?, otp_verified = 1, email_verified_at = ? WHERE email = ?');
$stmt->execute([$hashedPassword, date('Y-m-d H:i:s'), 'rjay@gmail.com']);

echo "User updated successfully\n";

// Verify
$stmt = $pdo->prepare('SELECT email, password, otp_verified, email_verified_at FROM users WHERE email = ?');
$stmt->execute(['rjay@gmail.com']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Verification:\n";
echo "Email: " . $user['email'] . "\n";
echo "OTP Verified: " . $user['otp_verified'] . "\n";
echo "Email Verified At: " . $user['email_verified_at'] . "\n";

// Test the password
if (password_verify('12345678', $user['password'])) {
    echo "Password test: PASSES ✓\n";
} else {
    echo "Password test: FAILS ✗\n";
}
?>
