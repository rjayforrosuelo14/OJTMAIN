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
        Schema::table('interns', function (Blueprint $table) {
            // Pre-Deployment Phase
            $table->string('resume')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->string('insurance')->nullable();
            $table->enum('pre_deployment_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('pre_deployment_accepted_at')->nullable();
            
            // Mid-Deployment Phase
            $table->string('memorandum_of_agreement')->nullable();
            $table->string('internship_contract')->nullable();
            $table->enum('mid_deployment_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('mid_deployment_accepted_at')->nullable();
            
            // Deployment Phase
            $table->string('recommendation_letter')->nullable();
            $table->enum('deployment_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('deployment_accepted_at')->nullable();
            
            // Overall phase tracking
            $table->enum('current_phase', ['pre_deployment', 'mid_deployment', 'deployment', 'completed'])->default('pre_deployment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            $table->dropColumn([
                'resume',
                'medical_certificate', 
                'insurance',
                'pre_deployment_status',
                'pre_deployment_accepted_at',
                'memorandum_of_agreement',
                'internship_contract',
                'mid_deployment_status',
                'mid_deployment_accepted_at',
                'recommendation_letter',
                'deployment_status',
                'deployment_accepted_at',
                'current_phase'
            ]);
        });
    }
};
