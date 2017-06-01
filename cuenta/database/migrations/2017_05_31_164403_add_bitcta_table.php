<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBitctaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitcta', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('bitc_fecha');
            $table->string('bitc_modulo');
            $table->string('bitcta_ip');
            $table->string('bitcta_naveg');
            $table->string('bitcta_tipo_op');
            $table->text('bitcta_msg');
            $table->text('bitcta_result');
            $table->text('bitcta_dato');
            $table->integer('bitcta_users_id')->unsigned();

            $table->foreign('bitcta_users_id')->references('id')->on('users');
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
        Schema::dropIfExists('bitcta');
    }
}
