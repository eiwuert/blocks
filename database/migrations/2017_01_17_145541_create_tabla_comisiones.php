<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaComisiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tabla_comisiones', function (Blueprint $table) {
            $table->string('tipo');
            $table->string('tipoPersona');
            $table->string('descripcion');
            $table->float('valor');
            $table->integer('orden');
            $table->primary(['tipo', 'tipoPersona', 'descripcion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Tabla_comisiones');
    }
}
