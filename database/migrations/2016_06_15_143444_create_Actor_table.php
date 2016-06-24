<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Actor', function (Blueprint $table) {
            $table->string('cedula')->unique();
            $table->string('nombre');
            $table->string('correo');
            $table->string('telefono');
            $table->enum('tipo_canal', array("Agentes", "Movishop", "TAT"));
            $table->enum('contratante',array("Movicom", "Cellphone"));
            $table->string('tipo_contrato');
            $table->double('sueldo',12,2);
            $table->string('jefe_cedula')->nullable();
            $table->integer("Ubicacion_ID")->unsigned();
            $table->float("porcentaje_equipo");
            $table->float("porcentaje_servicio");
            $table->float("porcentaje_libre");
            $table->float("porcentaje_prepago");
            $table->float("porcentaje_postpago");
            $table->foreign('Ubicacion_ID')->references('ID')->on('Ubicacion');
        });
        Schema::table('Actor', function (Blueprint $table) {
            $table->foreign('jefe_cedula')->references('cedula')->on('Actor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Actor');
    }
}
