<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Intern;

echo "=== Setting up Test Intern Account ===\n\n";

try {
    // Check if test intern exists
    $intern = Intern::where('email', 'testintern@example.com')->first();
    
    if ($intern) {
        echo "✓ Test intern already exists: " . $intern->email . "\n";
        echo "  Name: " . $intern->first_name . " " . $intern->last_name . "\n";
        echo "  Status: " . $intern->status . "\n";
        echo "  Phase: " . $intern->current_phase . "\n";
    } else {
        echo "Creating test intern...\n";
        $intern = Intern::create([
            'email' => 'testintern@example.com',
            'password' => bcrypt('password123'),
            'first_name' => 'Test',
            'last_name' => 'Intern',
            'course' => 'BSIT',
            'section' => 'A',
            'phone' => '1234567890',
            'supervisor_name' => 'Test Supervisor',
            'supervisor_position' => 'Manager',
            'supervisor_email' => 'supervisor@test.com',
            'company_name' => 'Test Company',
            'company_address' => '123 Test Street',
            'company_phone' => '9876543210',
            'status' => 'accepted', // Must be accepted to login
            'current_phase' => 'deployment',
            'pre_enrollment_status' => 'accepted',
            'pre_enrollment_accepted_at' => now()
        ]);
        echo "✓ Test intern created successfully!\n";
        echo "  Email: " . $intern->email . "\n";
        echo "  Password: password123\n";
    }
    
    echo "\n=== Login Test Info ===\n";
    echo "Email: " . $intern->email . "\n";
    echo "Password: " . ($intern->email === 'testintern@example.com' ? 'password123' : '12345678') . "\n";
    echo "\nYou can now login at: http://127.0.0.1:9002/intern/login\n";
    
    // Verify dashboard view exists
    echo "\n=== Checking Views ===\n";
    $viewPath = 'resources/views/intern-dashboard-professional.blade.php';
    echo "Professional dashboard: " . (file_exists($viewPath) ? "✓ EXISTS" : "✗ MISSING") . "\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
