<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Intern;

echo "=== Checking Database Connection ===\n\n";

try {
    // Check if user exists
    $user = User::where('email', 'rjay@gmail.com')->first();
    
    if ($user) {
        echo "✓ User found: " . $user->email . " | Name: " . $user->name . "\n";
    } else {
        echo "✗ User not found. Creating test user...\n";
        $user = User::create([
            'name' => 'RJAY',
            'email' => 'rjay@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now()
        ]);
        echo "✓ Test user created: " . $user->email . "\n";
    }
    
    echo "\nUser ID: " . $user->id . "\n";
    
    // Check interns table
    echo "\n=== Checking Interns Table ===\n";
    $internCount = Intern::count();
    echo "Total interns: " . $internCount . "\n";
    
    if ($internCount > 0) {
        $intern = Intern::first();
        echo "Sample intern: " . $intern->first_name . " " . $intern->last_name . "\n";
        echo "Status: " . $intern->status . "\n";
        echo "Phase: " . $intern->current_phase . "\n";
    }
    
    echo "\n✓ Database connection is working!\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
