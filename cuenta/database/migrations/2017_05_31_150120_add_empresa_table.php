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
            $table->text('empr_razsoc')->nullable();
            $table->string('empr_logo')->nullable();
            $table->string('empr_logotipo')->nullable();
            $table->string('empr_marc_agua')->nullable();
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
