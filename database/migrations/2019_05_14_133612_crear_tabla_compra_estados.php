<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCompraEstados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('compra_estados');
        Schema::create('compra_estados', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('compra_id')->unsigned();
            $table->enum('estado', ['creado', 'enviado', 'recibido', 'finalizado']);
            $table->timestamps();

            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
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
        Schema::dropIfExists('compra_estados');
    }
}
