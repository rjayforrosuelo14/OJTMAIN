<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            if (!Schema::hasColumn('interns', 'invited_by_user_id')) {
                $table->foreignId('invited_by_user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            if (Schema::hasColumn('interns', 'invited_by_user_id')) {
                $table->dropConstrainedForeignId('invited_by_user_id');
            }
        });
    }
};



