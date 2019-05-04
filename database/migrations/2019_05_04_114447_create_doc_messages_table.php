<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $message->file_name = $inMessage['document']['file_name'];
			$message->file_type = $inMessage['document']['mime_type'];
			$message->file_id= $inMessage['document']['file_id'];
			$message->file_size = $inMessage['document']['file_size'];
        Schema::create('doc_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->string('mime_type');
            $table->bigInteger('file_id');
            $table->bigInteger('file_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_messages');
    }
}
