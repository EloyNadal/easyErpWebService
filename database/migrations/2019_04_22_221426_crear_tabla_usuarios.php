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
        //Schema::dropIfExists('usuarios');
        //Schema::disableForeignKeyConstraints();
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('empleado_id')->unsigned();
            $table->string('user_name', 32);
            $table->integer('grupo_usuario_id')->unsigned();
            $table->string('password');
            $table->string('api_token');
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
        Schema::dropIfExists('usuarios');
    }
}
