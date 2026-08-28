<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('course');
            $table->string('section');
            $table->string('phone');
            $table->string('company_name');
            $table->string('company_phone');
            $table->string('supervisor_name');
            $table->string('supervisor_email');
            $table->string('application_letter');
            $table->string('parents_waiver');
            $table->string('acceptance_letter');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
