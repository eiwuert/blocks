<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Comision', function (Blueprint $table) {
            $table->increments('ID')->unique();
            $table->date('fecha');
            $table->string('Simcard_ICC');
            $table->float('valor');
            $table->foreign('Simcard_ICC')->references('ICC')->on('Simcard');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Comision');
    }
}
