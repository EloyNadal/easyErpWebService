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

        Schema::dropIfExists('clientes');
        Schema::create('clientes', function (Blueprint $table) {
            
            $table->increments('id')->unique();
            $table->integer('grupo_cliente_id')->unsigned();
            $table->string('nombre', 64);
            $table->string('apellidos', 64)->nullable();
            $table->string('direccion', 128)->nullable();
            $table->string('ciudad', 32)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('pais', 32)->nullable();
            $table->string('email', 64)->unique();
            $table->string('dni', 9)->unique();
            $table->string('codigo', 13)->unique();
            $table->timestamps();


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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('clientes');
    }
}
