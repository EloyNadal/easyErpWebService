<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaComprasLineas extends Migration
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
            $table->float('precio', 8, 2);
            $table->integer('tasa_id')->unsigned();
            $table->integer('cantidad');

            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('tasa_id')->references('id')->on('tasas')->onDelete('cascade');

        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('compra_lineas');
    }
}
