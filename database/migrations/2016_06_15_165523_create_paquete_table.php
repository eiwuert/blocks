<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Paquete', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Actor_cedula');
            $table->date('fecha_entrega')->nullable();
            $table->timestamps();
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
        Schema::drop('Paquete');
    }
}
