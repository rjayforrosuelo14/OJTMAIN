<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_id')->constrained('interns')->onDelete('cascade');
            $table->string('type'); // e.g., 'journal', 'application_letter', etc.
            $table->string('path')->nullable(); // if there's a file path
            $table->string('filename')->nullable(); // original file name
            $table->timestamp('submitted_at')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
