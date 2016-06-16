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
            $table->integer('Cliente_ID')->unsigned()->nullable();
            $table->foreign('Actor_cedula')->references('cedula')->on('Actor');
            $table->foreign('Cliente_ID')->references('ID')->on('Cliente');
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
