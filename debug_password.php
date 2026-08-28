<?php
require 'vendor/autoload.php';

// Connect to database directly
$pdo = new PDO('sqlite:database/database.sqlite');

// Get the user
$stmt = $pdo->prepare('SELECT id, email, password FROM users WHERE email = ?');
$stmt->execute(['rjay@gmail.com']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "User: " . $user['email'] . "\n";
    echo "Password hash: " . $user['password'] . "\n";
    echo "Password hash length: " . strlen($user['password']) . "\n";
    
    // Check if it's a valid bcrypt hash
    if (preg_match('/^\$2[aby]\$/', $user['password'])) {
        echo "Valid bcrypt hash format: YES\n";
    } else {
        echo "Valid bcrypt hash format: NO - This is the problem!\n";
    }
} else {
    echo "User not found\n";
}
?>
