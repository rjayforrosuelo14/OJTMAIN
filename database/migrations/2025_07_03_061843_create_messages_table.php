<?php

// database/migrations/xxxx_xx_xx_create_messages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->enum('sender_type', ['admin', 'intern']);
            $table->enum('receiver_type', ['admin', 'intern']);
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
