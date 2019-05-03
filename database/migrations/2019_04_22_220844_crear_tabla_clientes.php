<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('clientes', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('grupo_cliente_id')->unsigned();
            $table->string('nombre', 64);
            $table->string('apellidos', 64);
            $table->string('direccion', 128);
            $table->string('ciudad', 32);
            $table->string('telefono', 15);
            $table->string('codigo_postal', 10);
            $table->string('pais', 32);
            $table->string('email', 64);
            $table->string('dni', 10);
            $table->timestamps();

            $table->unique(['email', 'dni']);

            $table->foreign('grupo_cliente_id')
                ->references('id')->on('grupos_clientes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
