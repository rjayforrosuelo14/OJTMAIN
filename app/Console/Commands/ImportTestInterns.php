<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Intern;

class ImportTestInterns extends Command
{
    protected $signature = 'intern:import-test';
    protected $description = 'Import multiple test intern accounts';

    public function handle()
    {
        $this->info('=== Importing Test Intern Accounts ===');
        $this->newLine();

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
                'pre_enrollment_accepted_at' => now(),
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
                'pre_enrollment_accepted_at' => now(),
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
                'pre_enrollment_accepted_at' => now(),
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
                'pre_enrollment_accepted_at' => now(),
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
                'pre_enrollment_accepted_at' => now(),
            ],
        ];

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($testInterns as $internData) {
            $existing = Intern::where('email', $internData['email'])->first();
            
            if ($existing) {
                $this->line("⊘ Skipped: {$internData['email']} (already exists)");
                $skippedCount++;
                continue;
            }

            try {
                Intern::create($internData);
                $this->line("✓ Created: {$internData['first_name']} {$internData['last_name']} ({$internData['email']})");
                $createdCount++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to create {$internData['email']}: " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info('=== Import Summary ===');
        $this->line("Created: $createdCount interns");
        $this->line("Skipped: $skippedCount interns");
        $this->line("Total: " . Intern::count() . " interns");
        
        $this->newLine();
        $this->info('✅ Test accounts ready to use!');
        $this->line('Login at: http://127.0.0.1:8080/intern/login');
        $this->line('Password: password123');
    }
}
