<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Intern;

class CreateTestIntern extends Command
{
    protected $signature = 'intern:create-test';
    protected $description = 'Create a test intern account';

    public function handle()
    {
        $this->info('Creating test intern account...');

        try {
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
                'application_letter' => 'test.pdf',
                'parents_waiver' => 'test.pdf',
                'acceptance_letter' => 'test.pdf',
                'status' => 'accepted',
                'current_phase' => 'deployment',
                'pre_enrollment_status' => 'accepted',
                'pre_enrollment_accepted_at' => now()
            ]);

            $this->info('✓ Test intern created successfully!');
            $this->line('Email: ' . $intern->email);
            $this->line('Password: password123');
            $this->line('Status: ' . $intern->status);
            $this->line('Phase: ' . $intern->current_phase);
        } catch (\Exception $e) {
            $this->error('✗ Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
