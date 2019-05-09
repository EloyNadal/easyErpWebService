<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmpleadosUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //eliminar columna
        Schema::table('empleados', function (Blueprint $table) {
             $table->dropColumn('grupo_usuario_id');
             $table->dropColumn('password');
             $table->dropColumn('admin');
             $table->dropColumn('api_token');
        });

        Schema::table('usuarios', function (Blueprint $table) {
             $table->dropColumn('nombre');
             $table->dropColumn('apellidos');
             $table->dropColumn('email');
             $table->dropColumn('admin');
             $table->dropColumn('tienda_id');
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->integer('empleado_id')->unsigned();
             $table->string('user_name', 32);
             $table->integer('grupo_usuario_id')->unsigned();
        });

        Schema::create('grupo_usuarios', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('nombre', 64);            
            $table->enum('permiso', ['R', 'W']);
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

        Schema::table('empleados', function (Blueprint $table) {
             $table->integer('grupo_usuario_id')->unsigned();
             $table->boolean('admin');
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email'); //-> unique();
            $table->boolean('admin');
            $table->integer('tienda_id')->unsigned();
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('empleado_id');
            $table->dropColumn('user_name');
            $table->dropColumn('password');
            $table->dropColumn('grupo_usuario_id');
            $table->dropColumn('api_token');
        });


        Schema::dropIfExists('grupo_usuarios');

    }
}
