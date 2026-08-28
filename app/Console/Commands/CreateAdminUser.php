<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdminUser extends Command
{
    protected $signature = 'user:create-admin';
    protected $description = 'Create admin user account';

    public function handle()
    {
        $this->info('Creating admin user account...');

        try {
            // Check if admin already exists
            $existing = User::where('email', 'rjay@gmail.com')->first();
            
            if ($existing) {
                $this->warn('Admin user already exists!');
                $this->line('Email: ' . $existing->email);
                $this->line('Name: ' . $existing->name);
                return 0;
            }

            // Create admin user
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'rjay@gmail.com',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->info('✓ Admin user created successfully!');
            $this->newLine();
            $this->line('Email: ' . $admin->email);
            $this->line('Password: 12345678');
            $this->line('Name: ' . $admin->name);
            $this->newLine();
            $this->info('You can now login at: http://127.0.0.1:8080/login');

        } catch (\Exception $e) {
            $this->error('✗ Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
