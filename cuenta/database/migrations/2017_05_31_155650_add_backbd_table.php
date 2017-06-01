<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackbdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backbd', function (Blueprint $table) {
            $table->increments('id');
            $table->binary('backbd_back');
            $table->dateTime('backbd_fecha');
            $table->integer('backbd_bdapp_id')->unsigned();
            $table->foreign('backbd_bdapp_id')->references('id')->on('bdapp');

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
        Schema::dropIfExists('backbd');
    }
}
