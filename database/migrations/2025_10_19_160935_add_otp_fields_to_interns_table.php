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
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('otp_verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            $table->dropColumn(['otp_code', 'otp_expires_at', 'otp_verified']);
        });
    }
};
