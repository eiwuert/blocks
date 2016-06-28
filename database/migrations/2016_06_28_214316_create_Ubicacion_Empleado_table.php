<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbicacionEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ubicacion_Empleado', function (Blueprint $table) {
            $table->increments('ID')->unique();
            $table->date('fecha');
            $table->float('longitud');
            $table->float('latitud');
            $table->string('Actor_cedula');
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
        Schema::drop('Ubicacion_Empleado');
    }
}
