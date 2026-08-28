<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Change enum columns to accept 'supervisor' type as well
            if (!collect(DB::select("SHOW COLUMNS FROM messages LIKE 'sender_type'"))->first()?->Type || !str_contains(strtolower(collect(DB::select("SHOW COLUMNS FROM messages LIKE 'sender_type'"))->first()->Type), "'supervisor'")) {
                $table->enum('sender_type', ['admin', 'intern', 'supervisor'])->change();
            }

            if (!collect(DB::select("SHOW COLUMNS FROM messages LIKE 'receiver_type'"))->first()?->Type || !str_contains(strtolower(collect(DB::select("SHOW COLUMNS FROM messages LIKE 'receiver_type'"))->first()->Type), "'supervisor'")) {
                $table->enum('receiver_type', ['admin', 'intern', 'supervisor'])->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Revert to original enum values
            $table->enum('sender_type', ['admin', 'intern'])->change();
            $table->enum('receiver_type', ['admin', 'intern'])->change();
        });
    }
};
