<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRfcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rfc_nom');
            $table->string('rfc_num', 15);
            $table->text('rfc_razsoc');
            $table->binary('rfc_logo');
            $table->string('rfc_logotipo');
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
        Schema::dropIfExists('rfc');
    }
}
