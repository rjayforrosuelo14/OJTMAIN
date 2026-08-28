<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToSupervisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('supervisors', 'avatar')) {
            return;
        }

        Schema::table('supervisors', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supervisors', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
}
