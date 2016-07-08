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
            $table->string('Actor_cedula')->nullable();
            $table->string('Simcard_ICC')->nullable();
            $table->string('Cliente_identificacion')->nullable();
            $table->date('fecha_venta')->nullable();
            $table->string('Descripcion_Equipo_cod_scl');
            $table->enum('descripcion_precio', ["PREPAGO","POSTPAGO","3CUOTAS","6CUOTAS","9CUOTAS","12CUOTAS"])->nullable();
            $table->foreign('Simcard_ICC')->references('ICC')->on('Simcard');
            $table->foreign('Cliente_identificacion')->references('identificacion')->on('Cliente');
            $table->foreign('Descripcion_Equipo_cod_scl')->references('cod_scl')->on('Descripcion_Equipo');
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
        Schema::drop('Equipo');
    }
}
