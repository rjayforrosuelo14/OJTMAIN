<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Intern;
use App\Models\User;

echo "=== Importing OJT Test Data ===\n\n";

$testInterns = [
    [
        'email' => 'intern1@test.com',
        'password' => bcrypt('password123'),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'course' => 'BSIT',
        'section' => 'A',
        'phone' => '09121234567',
        'supervisor_name' => 'Maria Santos',
        'supervisor_position' => 'Operations Manager',
        'supervisor_email' => 'maria@company.com',
        'company_name' => 'Tech Solutions Inc',
        'company_address' => '123 Tech Street, Manila',
        'company_phone' => '02-123-4567',
        'application_letter' => 'letter1.pdf',
        'parents_waiver' => 'waiver1.pdf',
        'acceptance_letter' => 'acceptance1.pdf',
        'status' => 'accepted',
        'current_phase' => 'deployment',
        'pre_enrollment_status' => 'accepted',
    ],
    [
        'email' => 'intern2@test.com',
        'password' => bcrypt('password123'),
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'course' => 'BSIT',
        'section' => 'B',
        'phone' => '09129876543',
        'supervisor_name' => 'Carlos Rodriguez',
        'supervisor_position' => 'Project Lead',
        'supervisor_email' => 'carlos@company.com',
        'company_name' => 'Digital Innovations Ltd',
        'company_address' => '456 Innovation Ave, Quezon City',
        'company_phone' => '02-987-6543',
        'application_letter' => 'letter2.pdf',
        'parents_waiver' => 'waiver2.pdf',
        'acceptance_letter' => 'acceptance2.pdf',
        'status' => 'accepted',
        'current_phase' => 'mid-deployment',
        'pre_enrollment_status' => 'accepted',
    ],
    [
        'email' => 'intern3@test.com',
        'password' => bcrypt('password123'),
        'first_name' => 'Robert',
        'last_name' => 'Johnson',
        'course' => 'BSIT',
        'section' => 'A',
        'phone' => '09155551234',
        'supervisor_name' => 'Anna Cruz',
        'supervisor_position' => 'HR Director',
        'supervisor_email' => 'anna@company.com',
        'company_name' => 'Global Services Corp',
        'company_address' => '789 Business Park, Makati',
        'company_phone' => '02-555-1234',
        'application_letter' => 'letter3.pdf',
        'parents_waiver' => 'waiver3.pdf',
        'acceptance_letter' => 'acceptance3.pdf',
        'status' => 'accepted',
        'current_phase' => 'pre-deployment',
        'pre_enrollment_status' => 'accepted',
    ],
    [
        'email' => 'intern4@test.com',
        'password' => bcrypt('password123'),
        'first_name' => 'Sarah',
        'last_name' => 'Williams',
        'course' => 'BSIT',
        'section' => 'B',
        'phone' => '09177776666',
        'supervisor_name' => 'Fernando Lopez',
        'supervisor_position' => 'IT Manager',
        'supervisor_email' => 'fernando@company.com',
        'company_name' => 'InfoTech Solutions',
        'company_address' => '321 Tech Boulevard, Pasig',
        'company_phone' => '02-777-6666',
        'application_letter' => 'letter4.pdf',
        'parents_waiver' => 'waiver4.pdf',
        'acceptance_letter' => 'acceptance4.pdf',
        'status' => 'accepted',
        'current_phase' => 'deployment',
        'pre_enrollment_status' => 'accepted',
    ],
    [
        'email' => 'intern5@test.com',
        'password' => bcrypt('password123'),
        'first_name' => 'Michael',
        'last_name' => 'Brown',
        'course' => 'BSIT',
        'section' => 'C',
        'phone' => '09188885555',
        'supervisor_name' => 'Lisa Garcia',
        'supervisor_position' => 'Team Lead',
        'supervisor_email' => 'lisa@company.com',
        'company_name' => 'Enterprise Solutions',
        'company_address' => '555 Business District, BGC',
        'company_phone' => '02-888-5555',
        'application_letter' => 'letter5.pdf',
        'parents_waiver' => 'waiver5.pdf',
        'acceptance_letter' => 'acceptance5.pdf',
        'status' => 'accepted',
        'current_phase' => 'completed',
        'pre_enrollment_status' => 'accepted',
    ],
];

try {
    $createdCount = 0;
    $skippedCount = 0;

    foreach ($testInterns as $internData) {
        // Check if intern already exists
        $existing = Intern::where('email', $internData['email'])->first();
        
        if ($existing) {
            echo "⊘ Skipped: {$internData['email']} (already exists)\n";
            $skippedCount++;
            continue;
        }

        // Add timestamps
        $internData['pre_enrollment_accepted_at'] = now();
        $internData['created_at'] = now();
        $internData['updated_at'] = now();

        $intern = Intern::create($internData);
        echo "✓ Created: {$intern->first_name} {$intern->last_name} ({$intern->email}) - Phase: {$intern->current_phase}\n";
        $createdCount++;
    }

    echo "\n=== Import Summary ===\n";
    echo "Created: $createdCount interns\n";
    echo "Skipped: $skippedCount interns\n";
    echo "Total interns in system: " . Intern::count() . "\n";
    
    echo "\n✅ All test intern accounts are now connected to the system!\n";
    echo "\nYou can login with any of these accounts:\n";
    echo "Email: intern1@test.com through intern5@test.com\n";
    echo "Password: password123\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
