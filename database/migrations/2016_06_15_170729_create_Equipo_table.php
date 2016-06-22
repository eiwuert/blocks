<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Equipo', function (Blueprint $table) {
            $table->string('IMEI')->unique();
            $table->string('Simcard_ICC')->nullable();
            $table->string('Cliente_identificacion')->nullable();
            $table->date('fecha_venta')->nullable();
            $table->string('Descripcion_Equipo_cod_scl');
            $table->string('descripcion_precio');
            $table->foreign('Simcard_ICC')->references('ICC')->on('Simcard');
            $table->foreign('Cliente_identificacion')->references('identificacion')->on('Cliente');
            $table->foreign('Descripcion_Equipo_cod_scl')->references('cod_scl')->on('Descripcion_Equipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Equipo');
    }
}
