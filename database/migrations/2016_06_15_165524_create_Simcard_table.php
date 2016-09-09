<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Simcard', function (Blueprint $table) {
            $table->string('ICC')->unique();
            $table->string('numero_linea')->unique()->nullable();
            $table->string('categoria');
            $table->enum('contratante',array("Movicom", "Colphone"));
            $table->string("Cliente_identificacion")->nullable();
            $table->date('fecha_adjudicacion')->nullable();
            $table->date('fecha_asignacion')->nullable();
            $table->date('fecha_activacion')->nullable();
            $table->date('fecha_vencimiento');
            $table->date('fecha_venta')->nullable();
            $table->boolean('primer_pago')->default(false);
            $table->boolean('segundo_pago')->default(false);
            $table->boolean('tercer_pago')->default(false);
            $table->boolean('cuarto_pago')->default(false);
            $table->integer('Paquete_ID')->unsigned()->nullable();
            $table->foreign('Paquete_ID')->references('ID')->on('Paquete');
            $table->foreign('Cliente_identificacion')->references('identificacion')->on('Cliente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Simcard');
    }
}
