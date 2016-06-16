<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Servicio', function (Blueprint $table) {
            $table->string('peticion')->unique();
            $table->string('tipo_servicio');
            $table->string('tipo_fija')->nullable();
            $table->string('tipo_internet')->nullable();
            $table->string('tipo_tv')->nullable();
            $table->integer('Cliente_ID')->unsigned();
            $table->foreign('Cliente_ID')->references('ID')->on('Cliente')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Servicio');
    }
}
