<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('usuarios');
        
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('empleado_id')->unsigned();
            $table->string('user_name', 32);
            $table->integer('grupo_usuario_id')->unsigned();
            $table->string('password');
            $table->string('api_token');
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('grupo_usuario_id')->references('id')->on('grupo_usuarios')->onDelete('cascade');
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
        Schema::dropIfExists('usuarios');
    }
}
