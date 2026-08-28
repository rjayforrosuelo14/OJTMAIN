<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                            // Primary Key
            $table->string('name');                 // Name field
            $table->string('email')->unique();      // Unique email
            $table->timestamp('email_verified_at')->nullable(); // Optional email verification
            $table->string('password');             // Password (hashed)
            $table->rememberToken();                // For "remember me"
            $table->timestamps();                   // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
