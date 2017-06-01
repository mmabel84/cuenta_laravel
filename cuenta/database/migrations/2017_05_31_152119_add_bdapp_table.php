<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBdappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bdapp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bdapp_app');
            $table->string('bdapp_nombd');
            $table->string('bdapp_nomserv');
            $table->float('bdapp_gigcons');
            $table->float('bdapp_gigdisp');
            $table->integer('bdapp_empr_id')->unsigned();
            $table->foreign('bdapp_empr_id')->references('id')->on('empr');

            $table->timestamps();


        });

        //bdapp & rfc
        Schema::create('bdrfc', function (Blueprint $table){
            $table->increments('id');
            $table->integer('bdrfc_rfc_id')->unsigned();
            $table->integer('bdrfc_bdapp_id')->unsigned();

            $table->foreign('bdrfc_rfc_id')->references('id')->on('rfc');
            $table->foreign('bdrfc_bdapp_id')->references('id')->on('bdapp');

            $table->timestamps();


        });

        //bdapp & prov

        Schema::create('bdprov', function(Blueprint $table){
            $table->increments('id');
            $table->integer('bdprov_prov_id')->unsigned();
            $table->integer('bdprov_bdapp_id')->unsigned();

            $table->foreign('bdprov_prov_id')->references('id')->on('prov');
            $table->foreign('bdprov_bdapp_id')->references('id')->on('bdapp');


        });

        //bdapp & users

        Schema::create('bdusr', function(Blueprint $table){
            $table->increments('id');
            $table->integer('bdusr_bdapp_id')->unsigned();
            $table->integer('bdusr_bdusr_id')->unsigned();

            $table->foreign('bdusr_bdapp_id')->references('id')->on('bdapp');
            $table->foreign('bdusr_bdusr_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bdapp');
        Schema::dropIfExists('bdrfc');
        Schema::dropIfExists('bdprov');
        Schema::dropIfExists('bdusr');
    }
}
