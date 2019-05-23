<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaVentasProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('venta_lineas');
        Schema::create('venta_lineas', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('tienda_id')->unsigned();
            $table->integer('venta_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->float('precio', 8, 2);
            $table->integer('tasa_id')->unsigned();
            $table->integer('cantidad');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta_lineas');
    }
}
