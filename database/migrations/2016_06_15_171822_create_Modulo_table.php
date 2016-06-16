<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Modulo', function (Blueprint $table) {
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->string('Rol_nombre')->nullable();
            $table->foreign('Rol_nombre')->references('nombre')->on('Rol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Modulo');
    }
}
