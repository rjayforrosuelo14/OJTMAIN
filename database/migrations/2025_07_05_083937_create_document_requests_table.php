<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('document_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('intern_id')->constrained()->onDelete('cascade');
    $table->enum('type', ['midterm', 'final', 'certificate', 'evaluation']);
    $table->timestamp('requested_at');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
