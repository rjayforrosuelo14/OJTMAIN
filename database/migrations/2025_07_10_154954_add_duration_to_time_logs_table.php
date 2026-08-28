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
    Schema::table('time_logs', function (Blueprint $table) {
        $table->decimal('duration', 5, 2)->nullable()->after('time_out'); // stores hours like 7.5
    });
}

public function down()
{
    Schema::table('time_logs', function (Blueprint $table) {
        $table->dropColumn('duration');
    });
}
};
