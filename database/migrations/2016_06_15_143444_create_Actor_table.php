<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Actor', function (Blueprint $table) {
            $table->string('cedula')->unique();
            $table->string('nombre');
            $table->string('correo');
            $table->string('telefono');
            $table->enum('tipo_canal', array("Agentes", "Movishop", "TAT"));
            $table->enum('contratante',array("Movicom", "Cellphone"));
            $table->string('tipo_contrato');
            $table->double('sueldo',12,2);
            $table->string('jefe_cedula')->nullable();
            $table->timestamps();
        });
        Schema::table('Actor', function (Blueprint $table) {
            $table->foreign('jefe_cedula')->references('cedula')->on('Actor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Actor');
    }
}
