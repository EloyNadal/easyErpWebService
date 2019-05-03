<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAtributosValoresProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /*
        Schema::create('atributos_valores_productos', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('compania_id')->unsigned();
            $table->integer('atributo_valor_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->float('stock', 8, 3);


        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atributos_valores_productos');
    }
}
