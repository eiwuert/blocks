<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFijaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Fija', function (Blueprint $table) {
            $table->string('peticion')->unique();
            $table->string('tipo_servicio');
            $table->string('tipo_fija')->nullable();
            $table->string('tipo_internet')->nullable();
            $table->string('tipo_tv')->nullable();
            $table->string('Cliente_identificacion');
            $table->foreign('Cliente_identificacion')->references('identificacion')->on('Cliente')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Fija');
    }
}
