<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmoAccountSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amo_account_settings', function (Blueprint $table) {
            $table->integer('account_id')->primary();
            $table->string('amojo_id', 256);
            $table->string('scope_id', 256)->nullable();
            $table->string('domain', 256);
            $table->text('refresh_token');
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
        Schema::dropIfExists('amo_account_settings');
    }
}
