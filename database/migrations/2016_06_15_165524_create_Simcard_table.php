<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Simcard', function (Blueprint $table) {
            $table->string('ICC')->unique();
            $table->string('numero_linea');
            $table->string('categoria');
            $table->date('fecha_adjudicacion')->nullable();
            $table->date('fecha_asignacion')->nullable();
            $table->date('fecha_activacion')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->integer('Cliente_ID')->unsigned()->nullable();
            $table->string('Actor_cedula')->nullable();
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
        Schema::drop('Simcard');
    }
}
