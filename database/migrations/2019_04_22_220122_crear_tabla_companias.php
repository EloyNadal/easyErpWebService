<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCompanias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('companias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 40);
            $table->string('cif', 9);
            $table->integer('direccion_id')->unsigned();
            $table->integer('divisa_id')->unsigned();
            $table->timestamps();
            
            $table->unique(['nombre', 'cif']);

            $table->foreign('direccion_id')
                ->references('id')->on('direcciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');


        }); 
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companias');
    }
}
