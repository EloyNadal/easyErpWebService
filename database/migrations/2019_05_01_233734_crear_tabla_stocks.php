<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('stocks');
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('tienda_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('cantidad');

            $table->unique(['tienda_id', 'producto_id']);

            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
