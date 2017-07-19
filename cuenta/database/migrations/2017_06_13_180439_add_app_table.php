<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_nom');
            $table->string('app_cod');
            $table->integer('app_insts')->nullable();
            $table->float('app_megs')->nullable();
            $table->boolean('app_activa')->default(true);
            $table->string('app_estado')->nullable();
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
        Schema::dropIfExists('app');
    }
}
