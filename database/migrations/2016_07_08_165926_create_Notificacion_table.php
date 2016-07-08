<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Notificacion', function (Blueprint $table) {
            $table->increments('ID')->unique();
            $table->string('Actor_cedula');
            $table->boolean('exito');
            $table->string('descripcion');
            $table->foreign('Actor_cedula')->references('cedula')->on('Actor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Notificacion');
    }
}
