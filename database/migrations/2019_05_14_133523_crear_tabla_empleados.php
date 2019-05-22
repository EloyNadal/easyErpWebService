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
            $table->string('email', 64);
            $table->string('dni', 10);
            $table->integer('tienda_id')->unsigned();

            $table->timestamps();

            $table->unique(['email', 'dni']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
