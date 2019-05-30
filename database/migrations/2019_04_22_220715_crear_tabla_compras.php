<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('compras');
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('tienda_id')->unsigned();
            $table->integer('proveedor_id')->unsigned();
            $table->float('precio_sin_tasas', 8, 2);
            $table->float('total_tasas', 8, 2);
            $table->float('precio_total', 8, 2);
            $table->timestamps();

            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');
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
        Schema::dropIfExists('compras');
    }
}
