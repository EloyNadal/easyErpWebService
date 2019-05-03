<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 64);
            $table->string('direccion', 128);
            $table->string('ciudad', 32);
            $table->string('telefono', 15);
            $table->string('email', 64);
            $table->string('codigo_postal', 10);
            $table->string('pais', 32);
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
        Schema::dropIfExists('proveedores');
    }
}
