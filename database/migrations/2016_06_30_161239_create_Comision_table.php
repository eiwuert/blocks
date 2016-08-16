<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Comision', function (Blueprint $table) {
            $table->increments('ID')->unique();
            $table->date('fecha');
            $table->float('valor');
            $table->string('Simcard_ICC')->nullable();
            $table->string('Equipo_IMEI')->nullable();
            $table->string('Servicio_peticion')->nullable();
            $table->foreign('Simcard_ICC')->references('ICC')->on('Simcard');
            $table->foreign('Equipo_IMEI')->references('IMEI')->on('Equipo');
            $table->foreign('Servicio_peticion')->references('peticion')->on('Servicio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Comision');
    }
}
