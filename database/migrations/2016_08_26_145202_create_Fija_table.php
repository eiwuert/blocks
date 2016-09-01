<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFijaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Fija', function (Blueprint $table) {
            $table->string('peticion')->unique();
            $table->date('fecha_venta');
            $table->string('linea_base')->nullable();
            $table->string('internet')->nullable();
            $table->string('tv')->nullable();
            $table->string('Actor_cedula');
            $table->string('Cliente_identificacion');
            $table->foreign('Cliente_identificacion')->references('identificacion')->on('Cliente')->onDelete('cascade');
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
        Schema::drop('Fija');
    }
}
