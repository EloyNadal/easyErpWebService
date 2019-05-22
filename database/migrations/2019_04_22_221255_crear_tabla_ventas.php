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
            $table->float('precio_sin_tasas', 8, 3);
            $table->float('total_tasas', 8, 3);
            $table->float('precio_total', 8, 3);            
            $table->timestamps();

            $table->unique(['id', 'tienda_id']);

        });


    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
