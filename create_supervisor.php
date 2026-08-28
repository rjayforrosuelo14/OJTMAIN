<?php
require 'vendor/autoload.php';

$pdo = new PDO('sqlite:database/database.sqlite');

// Create supervisor with approved status
$email = 'supervisor@example.com';
$password = password_hash('12345678', PASSWORD_BCRYPT, ['rounds' => 12]);

// Check if supervisor already exists
$stmt = $pdo->prepare('SELECT id FROM supervisors WHERE email = ?');
$stmt->execute([$email]);
$existing = $stmt->fetch();

if ($existing) {
    echo "Supervisor already exists!\n";
    echo "Email: " . $email . "\n";
    echo "Password: 12345678\n";
} else {
    // Create the supervisor
    $stmt = $pdo->prepare('INSERT INTO supervisors (name, email, password, is_accepted, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
    $now = date('Y-m-d H:i:s');
    $stmt->execute(['Test Supervisor', $email, $password, 1, $now, $now]);
    
    echo "✓ Supervisor created successfully!\n";
    echo "Email: " . $email . "\n";
    echo "Password: 12345678\n";
}
?>
