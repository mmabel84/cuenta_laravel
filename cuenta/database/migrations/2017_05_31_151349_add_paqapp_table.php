<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaqappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paqapp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('paqapp_nomapp');
            $table->integer('paqapp_cantrfc')->nullable();
            $table->float('paqapp_cantgig')->nullable();
            $table->date('paqapp_f_venta');
            $table->date('paqapp_f_act')->nullable();
            $table->date('paqapp_f_fin');
            $table->date('paqapp_f_caduc')->nullable();
            $table->boolean('paqapp_activo')->default(True);
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
        Schema::dropIfExists('paqapp');
    }
}
