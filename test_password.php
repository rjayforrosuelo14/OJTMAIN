<?php
require 'vendor/autoload.php';

// Connect to database directly
$pdo = new PDO('sqlite:database/database.sqlite');

// Get the user
$stmt = $pdo->prepare('SELECT id, email, password FROM users WHERE email = ?');
$stmt->execute(['rjay@gmail.com']);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Testing password '12345678' against hash:\n";
    echo "Hash: " . $user['password'] . "\n";
    
    if (password_verify('12345678', $user['password'])) {
        echo "Result: PASSWORD MATCHES ✓\n";
    } else {
        echo "Result: PASSWORD DOES NOT MATCH ✗\n";
    }
} else {
    echo "User not found\n";
}
?>
