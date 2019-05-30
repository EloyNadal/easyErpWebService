<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpleados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('empleados');
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('nombre', 64);
            $table->string('apellidos', 64)->nullable();
            $table->string('direccion', 128)->nullable();
            $table->string('ciudad', 32)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('pais', 32)->nullable();
            $table->string('email', 64)->unique();
            $table->string('dni', 10)->unique();
            $table->integer('tienda_id')->unsigned();

            $table->timestamps();

            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('cascade');

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
        Schema::dropIfExists('empleados');
    }
}
