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
            $table->string('Cliente_identificacion');
            $table->foreign('Cliente_identificacion')->references('identificacion')->on('Cliente')->onDelete('cascade');
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
