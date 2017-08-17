<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backbd', function($table)
            {
                $table->string('backbd_coment')->nullable();
                $table->integer('backbd_number')->nullable();
                $table->boolean('backbd_respaldado')->default(False)->nullable();
                $table->dateTime('backbd_f_respaldo')->nullable();

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
