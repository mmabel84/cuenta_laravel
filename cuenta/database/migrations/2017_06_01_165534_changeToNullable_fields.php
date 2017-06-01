<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeToNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empr', function (Blueprint $table) {
            $table->string('empr_razsoc')->nullable()->change();
            $table->string('empr_logo')->nullable()->change();
            $table->dateTime('empr_logotipo')->nullable()->change();
            $table->dateTime('empr_marc_agua')->nullable()->change();
        });

        Schema::table('rfc', function (Blueprint $table) {
            $table->string('rfc_razsoc')->nullable()->change();
            $table->string('rfc_logo')->nullable()->change();
            $table->dateTime('rfc_logotipo')->nullable()->change();
        });

        Schema::table('rfc', function (Blueprint $table) {
            $table->string('rfc_razsoc')->nullable()->change();
            $table->string('rfc_logo')->nullable()->change();
            $table->dateTime('rfc_logotipo')->nullable()->change();
        });

        Schema::table('bitcta', function (Blueprint $table) {
            $table->string('bitc_modulo')->nullable()->change();
            $table->string('bitcta_ip')->nullable()->change();
            $table->dateTime('bitcta_naveg')->nullable()->change();
            $table->dateTime('bitcta_tipo_op')->nullable()->change();
            $table->dateTime('bitcta_msg')->nullable()->change();
            $table->dateTime('bitcta_result')->nullable()->change();
            $table->dateTime('bitcta_dato')->nullable()->change();
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
