<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        try {
            Mail::raw('This is a test email from OJT Management System to verify email configuration.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - OJT Management System');
            });
            
            $this->info("Test email sent successfully to {$email}!");
        } catch (\Exception $e) {
            $this->error("Failed to send test email: " . $e->getMessage());
        }
    }
}
