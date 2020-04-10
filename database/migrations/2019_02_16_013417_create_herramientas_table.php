<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHerramientasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('herramientas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('cant_inicial');
            $table->bigInteger('cant_actual');
            $table->bigInteger('disponible_bodega');
            $table->text('descripcion');
            $table->decimal('precio');
            $table->dateTime('fecha_compra');
            $table->text('marca')->nullable();
            $table->text('modelo')->nullable();
            $table->decimal('descuento')->nullable();
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
        Schema::dropIfExists('herramientas');
    }
}
