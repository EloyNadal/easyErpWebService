<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProductoProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('producto_proveedores');
        Schema::create('producto_proveedores', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('proveedor_id')->unsigned();
            $table->integer('producto_id')->unsigned()->unique();

            //$table->unique(['proveedor_id', 'producto_id']);

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

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
        Schema::dropIfExists('producto_proveedores');
    }
}
