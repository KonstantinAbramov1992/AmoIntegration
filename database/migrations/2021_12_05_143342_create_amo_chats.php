<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmoChats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amo_chats', function (Blueprint $table) {
            $table->id('conversation_id')->autoIncrement();
            $table->string('conversation_ref_id', 256)->nullable();
            $table->integer('account_id');
            $table->integer('user_id');
            $table->integer('contact_id');
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
        Schema::dropIfExists('amo_user_chats');
    }
}
