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
            $table->string('attendance_status')->default('not_released')->after('attendance_released_at');
            $table->timestamp('attendance_time')->nullable()->after('attendance_status');
            $table->text('attendance_notes')->nullable()->after('attendance_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            $table->dropColumn(['attendance_status', 'attendance_time', 'attendance_notes']);
        });
    }
};
