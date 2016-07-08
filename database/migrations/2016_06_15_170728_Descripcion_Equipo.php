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
            $table->string('modelo');
            $table->string('tecnologia');
            $table->double('precio_prepago',10,2);
            $table->double('precio_contado',10,2);
            $table->double('precio_3_cuotas',10,2);
            $table->double('precio_6_cuotas',10,2);
            $table->double('precio_12_cuotas',10,2);
            $table->double('precio_24_cuotas',10,2);
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
