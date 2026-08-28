<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('interns', function (Blueprint $table) {
        $table->string('status')->default('pending'); // pending, accepted, rejected
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interns', function (Blueprint $table) {
            //
        });
    }
};
