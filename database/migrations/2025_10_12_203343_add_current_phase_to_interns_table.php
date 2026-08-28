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
        if (Schema::hasTable('interns') && !Schema::hasColumn('interns', 'current_phase')) {
            Schema::table('interns', function (Blueprint $table) {
                $table->string('current_phase')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('interns') && Schema::hasColumn('interns', 'current_phase')) {
            Schema::table('interns', function (Blueprint $table) {
                $table->dropColumn('current_phase');
            });
        }
    }
};
