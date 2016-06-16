<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Plan', function (Blueprint $table) {
            $table->string('codigo')->unique();
            $table->integer('cantidad_minutos')->unsigned();
            $table->string('cantidad_datos');
            $table->float('valor');
            $table->string('descripcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Plan');
    }
}
