<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DescripcionEquipo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Descripcion_Equipo', function (Blueprint $table) {
            $table->string('cod_scl')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->enum('gama',['ALTA','MEDIA','BAJA']);
            $table->float('precio_prepago');
            $table->float('precio_postpago');
            $table->float('precio_3_cuotas');
            $table->float('precio_6_cuotas');
            $table->float('precio_9_cuotas');
            $table->float('precio_12_cuotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Descripcion_Equipo');
    }
}
