<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErroresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Error', function (Blueprint $table) {
            $table->increments('ID')->unique();
            $table->string('descripcion');
            $table->integer('Notificacion_ID')->unsigned();
            $table->foreign('Notificacion_ID')->references('ID')->on('Notificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Error');
    }
}
