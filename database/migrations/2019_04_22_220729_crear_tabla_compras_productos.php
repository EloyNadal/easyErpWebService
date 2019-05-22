<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaComprasProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('compra_lineas');
        Schema::create('compra_lineas', function (Blueprint $table) {
            
            $table->increments('id')->unique();
            $table->integer('tienda_id')->unsigned();
            $table->integer('compra_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->float('precio', 8, 3);
            $table->integer('tasa_id')->unsigned();
            $table->float('cantidad', 8, 3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras_productos');
        Schema::dropIfExists('compra_lineas');
    }
}
