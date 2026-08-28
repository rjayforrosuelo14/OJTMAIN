<?php
// Simple test to verify intern registration works
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use App\Models\Intern;

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing intern registration...\n";

// Check if required columns exist
echo "Checking database columns:\n";
echo "- supervisor_position: " . (Schema::hasColumn('interns', 'supervisor_position') ? 'EXISTS' : 'MISSING') . "\n";
echo "- company_address: " . (Schema::hasColumn('interns', 'company_address') ? 'EXISTS' : 'MISSING') . "\n";

// Test data
$testData = [
    'email' => 'test_' . time() . '@example.com',
    'password' => bcrypt('password123'),
    'first_name' => 'Test',
    'last_name' => 'User',
    'course' => 'BSIT',
    'section' => 'A',
    'phone' => '1234567890',
    'supervisor_name' => 'Test Supervisor',
    'supervisor_position' => 'Manager',
    'supervisor_email' => 'supervisor@test.com',
    'company_name' => 'Test Company',
    'company_address' => 'Test Address',
    'company_phone' => '',
    'application_letter' => '',
    'parents_waiver' => '',
    'acceptance_letter' => '',
    'status' => 'pending',
    'current_phase' => 'pre_deployment',
    'pre_enrollment_status' => 'pending',
];

try {
    $intern = Intern::create($testData);
    echo "SUCCESS: Intern created with ID: " . $intern->id . "\n";
    echo "Registration should now work properly!\n";
    
    // Clean up test data
    $intern->delete();
    echo "Test data cleaned up.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "Test complete.\n";