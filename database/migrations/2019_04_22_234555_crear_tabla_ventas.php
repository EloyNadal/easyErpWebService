<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('ventas');
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('tienda_id')->unsigned();
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->integer('usuario_id')->unsigned();
            $table->float('precio_sin_tasas', 8, 2);
            $table->float('total_tasas', 8, 2);
            $table->float('precio_total', 8, 2);
            $table->boolean('efectivo');
            $table->boolean('tarjeta');            
            $table->timestamps();
            $table->unique(['id', 'tienda_id']);

            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');

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
        Schema::dropIfExists('ventas');
    }
}
