<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmoMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amo_messages', function (Blueprint $table) {
            $table->id('message_id')->autoIncrement();
            $table->string('message_ref_id', 256)->nullable();
            $table->string('conversation_id', 256);
            $table->string('conversation_ref_id', 256)->nullable();
            $table->timestamp('time_sended');
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
        Schema::dropIfExists('amo_messages');
    }
}
