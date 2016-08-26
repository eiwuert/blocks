<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cliente', function (Blueprint $table) {
            $table->string('identificacion')->unique();
            $table->enum('tipo',["NATURAL","EMPRESA"]);
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('direccion')->nullable();
            $table->integer("Ubicacion_ID")->unsigned();
            $table->foreign('Ubicacion_ID')->references('ID')->on('Ubicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Cliente');
    }
}
