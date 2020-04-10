<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_herramienta')->unsigned();
            $table->foreign('id_herramienta')->references('id')->on('herramientas')->onDelete('cascade');
            $table->bigInteger('cantidad');
            $table->text('descripcion');
            $table->text('solicitante');            
            $table->dateTime('fecha_salida');
            $table->dateTime('fecha_retorno');
            $table->bigInteger('pendiente_entrega');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salidas');
    }
}
