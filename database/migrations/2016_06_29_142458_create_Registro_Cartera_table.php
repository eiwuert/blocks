<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroCarteraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Registro_Cartera', function (Blueprint $table) {
            $table->increments('ID')->unique();
            $table->date('fecha');
            $table->integer('cantidad');
            $table->float('valor_unitario');
            $table->string('descripcion');
            $table->string('Actor_cedula');
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
        Schema::drop('Registro_Cartera');
    }
}
