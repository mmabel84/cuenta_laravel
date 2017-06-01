<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empr', function (Blueprint $table) {
            $table->increments('id');
            $table->string('empr_nom');
            $table->string('empr_rfc', 15);
            $table->text('empr_razsoc');
            $table->binary('empr_logo');
            $table->string('empr_logotipo');
            $table->binary('empr_marc_agua');
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
        Schema::dropIfExists('empr');
    }
}
