<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmprFecha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empr', function (Blueprint $table) {
          
            $table->boolean('empr_principal')->default(False);
            $table->dateTime('empr_f_iniciovig')->nullable();
            $table->dateTime('empr_f_finvig')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
