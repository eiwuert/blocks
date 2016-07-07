<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionPermisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Asignacion_Permiso', function (Blueprint $table) {
            $table->string('User_email');
            $table->enum('permiso', ["PAQUETES", "ARCHIVOS"]);
            $table->foreign('User_email')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['User_email', 'permiso']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Asignacion_Permiso');
    }
}
