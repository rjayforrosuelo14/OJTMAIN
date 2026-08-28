<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            if (!Schema::hasColumn('interns', 'archived_at')) {
                $table->timestamp('archived_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            if (Schema::hasColumn('interns', 'archived_at')) {
                $table->dropColumn('archived_at');
            }
        });
    }
};




