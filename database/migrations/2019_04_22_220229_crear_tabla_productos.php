<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('productos');
        Schema::disableForeignKeyConstraints();

        Schema::create('productos', function (Blueprint $table) {



            $table->increments('id');
            $table->integer('categoria_id')->unsigned();
            $table->string('ean13', 13);
            $table->string('referencia', 32);
            $table->string('atributo', 16);
            $table->string('atributo_valor', 16);
            $table->string('nombre', 64);
            $table->string('unidad_mesura', 16);
            $table->float('precio', 8, 3);
            $table->integer('tasa_id')->unsigned();
            $table->float('stock_minimo', 8, 3);
            $table->boolean('activo');
            $table->string('fabricante', 32);
            $table->string('imagen', 128);
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
        Schema::dropIfExists('productos');
    }
}
