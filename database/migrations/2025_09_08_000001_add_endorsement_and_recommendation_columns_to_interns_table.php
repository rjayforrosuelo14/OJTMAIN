<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            if (!Schema::hasColumn('interns', 'recommendation_letter')) {
                $table->string('recommendation_letter')->nullable();
            }
            if (!Schema::hasColumn('interns', 'endorsement_letter')) {
                $table->string('endorsement_letter')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            if (Schema::hasColumn('interns', 'recommendation_letter')) {
                $table->dropColumn('recommendation_letter');
            }
            if (Schema::hasColumn('interns', 'endorsement_letter')) {
                $table->dropColumn('endorsement_letter');
            }
        });
    }
};


