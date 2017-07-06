<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCertificado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cert', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cert_rfc');
            $table->dateTime('cert_f_fin')->nullable();
            $table->dateTime('cert_f_inicio')->nullable();
            $table->string('cert_filename')->nullable();
            $table->string('cert_file_storage')->nullable();
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
