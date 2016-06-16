<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Comision_Persona', function (Blueprint $table) {
            $table->string('tipo_producto');
            $table->float('porcentaje');
            $table->string('Actor_cedula');
            $table->primary(array('tipo_producto','Actor_cedula'));
            $table->foreign('Actor_cedula')->references('cedula')->on('Actor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Comision_Persona');
    }
}
