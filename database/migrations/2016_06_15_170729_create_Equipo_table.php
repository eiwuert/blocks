<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Equipo', function (Blueprint $table) {
            $table->string('IMEI')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->string('gama');
            $table->string('cod_scl');
            $table->float('precio_prepago');
            $table->float('precio_postpago');
            $table->float('precio_3_cuotas');
            $table->float('precio_6_cuotas');
            $table->float('precio_9_cuotas');
            $table->float('precio_12_cuotas');
            $table->string('Simcard_ICC')->nullable();
            $table->integer('Cliente_ID')->unsigned()->nullable();
            $table->foreign('Simcard_ICC')->references('ICC')->on('Simcard');
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
        Schema::drop('Equipo');
    }
}
