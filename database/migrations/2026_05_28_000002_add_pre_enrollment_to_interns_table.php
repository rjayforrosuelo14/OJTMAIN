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
            if (!Schema::hasColumn('interns', 'pre_enrollment_status')) {
                $table->enum('pre_enrollment_status', ['pending', 'accepted', 'rejected'])->default('pending')->after('current_phase');
            }
            if (!Schema::hasColumn('interns', 'pre_enrollment_accepted_at')) {
                $table->timestamp('pre_enrollment_accepted_at')->nullable()->after('pre_enrollment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            $table->dropColumn(['pre_enrollment_status', 'pre_enrollment_accepted_at']);
        });
    }
};
