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
            $table->increments('ID');
            $table->string('tipo');
            $table->string('Cliente_Empresa_NIT')->nullable();
            $table->string('Cliente_Natural_cedula')->nullable();
            $table->string('nombre');
            $table->string('telefono');
            $table->string('correo');
            $table->foreign('Cliente_Empresa_NIT')->references('NIT')->on('Cliente_Empresa')->onDelete('cascade');
            $table->foreign('Cliente_Natural_cedula')->references('cedula')->on('Cliente_Natural')->onDelete('cascade');
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
