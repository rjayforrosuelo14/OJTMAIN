<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_id')->constrained()->onDelete('cascade');
            $table->enum('semester', ['1st', '2nd', '3rd', '4th']);
            $table->string('file_path');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_submissions');
    }
};
