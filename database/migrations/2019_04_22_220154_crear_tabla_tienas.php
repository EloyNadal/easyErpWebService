<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTienas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        
        Schema::dropIfExists('tiendas');   
        Schema::create('tiendas', function (Blueprint $table) {

            $table->increments('id')->unique();
            $table->string('nombre', 64);
            $table->string('direccion', 128)->nullable();
            $table->string('ciudad', 32)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('email', 64)->unique();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('pais', 32)->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tiendas');
    }
}
