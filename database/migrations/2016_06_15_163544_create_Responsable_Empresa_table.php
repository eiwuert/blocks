<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsableEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Responsable_Empresa', function (Blueprint $table) {
            $table->string('cedula')->unique();
            $table->string('nombre');
            $table->string('telefono');
            $table->string('correo');
            $table->string('Cliente_Empresa_NIT');
            $table->foreign('Cliente_Empresa_NIT')->references('NIT')->on('Cliente_Empresa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Responsable_Empresa');
    }
}
