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
            $table->string('ean13', 13);
            $table->string('referencia', 32);
            $table->string('atributo', 16)->nullable();
            $table->string('atributo_valor', 16)->nullable();
            $table->string('nombre', 64);
            $table->string('unidad_mesura', 16)->nullable();
            $table->float('precio', 8, 2);
            $table->integer('tasa_id')->unsigned();
            $table->integer('stock_minimo')->nullable();
            $table->boolean('activo');
            $table->string('fabricante', 32)->nullable();
            $table->string('imagen', 128)->nullable();
            $table->timestamps();

            $table->unique(['ean13']);

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
