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



            $table->increments('id')->unique();
            $table->integer('categoria_id')->unsigned();
            $table->string('ean13', 13)->nullable();
            $table->string('referencia', 32);
            $table->string('atributo', 16)->nullable();
            $table->string('atributo_valor', 16)->nullable();
            $table->string('nombre', 64);
            $table->string('unidad_mesura', 16)->nullable();
            $table->float('precio', 8, 3);
            $table->integer('tasa_id')->unsigned();
            $table->float('stock_minimo', 8, 3)->nullable();
            $table->boolean('activo');
            $table->string('fabricante', 32)->nullable();
            $table->string('imagen', 128)->nullable();
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
