<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Asignacion_Rol', function (Blueprint $table) {
            $table->string('users_email')->unique();
            $table->string('Rol_nombre')->unique();
            $table->foreign('users_email')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Rol_nombre')->references('nombre')->on('Rol')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Asignacion_Rol');
    }
}
