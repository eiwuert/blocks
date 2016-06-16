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
            $table->date('fecha_vencimiento');
            $table->integer('Paquete_ID')->unsigned()->nullable();
            $table->foreign('Paquete_ID')->references('ID')->on('Paquete');
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
