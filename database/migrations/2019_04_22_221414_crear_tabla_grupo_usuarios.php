<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaGrupoUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('grupo_usuarios');
        Schema::create('grupo_usuarios', function (Blueprint $table) {

            $table->increments('id')->unique();
            $table->string('nombre', 64);            
            $table->enum('permiso', ['R', 'W']);

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
        Schema::dropIfExists('grupo_usuarios');
    }
}
