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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ventas_productos');
        Schema::dropIfExists('venta_lineas');
        Schema::create('venta_lineas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tienda_id')->unsigned();
            $table->integer('venta_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->float('precio', 8, 3);
            $table->integer('tasa_id')->unsigned();
            $table->float('cantidad', 8, 3);
            $table->string('unidad_mesura', 16);


          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas_productos');
        Schema::dropIfExists('venta_lineas');
    }
}
