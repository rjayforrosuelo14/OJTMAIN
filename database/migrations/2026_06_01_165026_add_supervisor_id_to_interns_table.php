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
        if (Schema::hasColumn('interns', 'supervisor_id')) {
            return;
        }

        Schema::table('interns', function (Blueprint $table) {
            $table->unsignedBigInteger('supervisor_id')->nullable()->after('id');
            $table->foreign('supervisor_id')->references('id')->on('supervisors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropColumn('supervisor_id');
        });
    }
};
