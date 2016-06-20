<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Asignacion_Plan', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('Plan_codigo');
            $table->string('Simcard_ICC');
            $table->foreign('Plan_codigo')->references('codigo')->on('Plan')->onDelete('cascade');
            $table->foreign('Simcard_ICC')->references('ICC')->on('Simcard')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Asignacion_Plan');
    }
}
