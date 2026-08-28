<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('email', 'rjay@gmail.com')
            ->update([
                'otp_verified' => 1,
                'email_verified_at' => DB::raw('current_timestamp')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
