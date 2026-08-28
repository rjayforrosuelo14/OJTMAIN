<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_grade_requests_table.php
public function up()
{
    Schema::create('grade_requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('intern_id');
        $table->enum('type', ['Midterm', 'Final', 'Certificate', 'Evaluation Form']);
        $table->boolean('fulfilled')->default(false);
        $table->timestamps();

        $table->foreign('intern_id')->references('id')->on('interns')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_requests');
    }
};
