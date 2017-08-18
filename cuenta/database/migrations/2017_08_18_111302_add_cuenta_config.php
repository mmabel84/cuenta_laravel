<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCuentaConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ctaconf', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('ctaconf_bloq')->default(false);
            $table->dateTime('ctaconf_f_creacion')->nullable();
            $table->string('ctaconf_rfc');
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
        //
    }
}
