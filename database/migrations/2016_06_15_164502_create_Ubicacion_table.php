<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ubicacion', function (Blueprint $table) {
            $table->string('region');
            $table->string('ciudad');
            $table->string('direccion')->nullable();
            $table->string('Actor_cedula')->nullable();
            $table->string('Cliente_identificacion')->nullable();
            $table->foreign('Actor_cedula')->references('cedula')->on('Actor');
            $table->foreign('Cliente_identificacion')->references('identificacion')->on('Cliente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Ubicacion');
    }
}
