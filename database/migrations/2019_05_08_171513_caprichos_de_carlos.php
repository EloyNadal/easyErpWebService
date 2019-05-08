<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CaprichosDeCarlos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->renameColumn('stock','cantidad');
        });
        
        //cambiar nombre precio / iva
        Schema::table('ventas', function (Blueprint $table) {
            $table->renameColumn('precio','precio_sin_tasas');
            $table->renameColumn('iva','total_tasas');
        });

        //cambiar nombre precio / iva
        Schema::table('compras', function (Blueprint $table) {
            $table->renameColumn('precio','precio_sin_tasas');
            $table->renameColumn('iva','total_tasas');
        });

        //eliminar columna unidad_mesura
        Schema::table('venta_lineas', function (Blueprint $table) {
             $table->dropColumn('unidad_mesura');
        });

        //eliminar columna unidad_mesura
        Schema::table('compra_lineas', function (Blueprint $table) {
             $table->dropColumn('unidad_mesura');
        });

        //tabla empleados
        Schema::create('empleados', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('grupo_usuario_id')->unsigned();
            $table->string('nombre', 64);
            $table->string('apellidos', 64);
            $table->string('direccion', 128);
            $table->string('ciudad', 32);
            $table->string('telefono', 15);
            $table->string('codigo_postal', 10);
            $table->string('pais', 32);
            $table->string('email', 64);
            $table->string('dni', 10);
            $table->string('password');
            $table->boolean('admin');
            $table->integer('tienda_id')->unsigned();
            $table->string('api_token');

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
        Schema::table('stocks', function (Blueprint $table) {
            $table->renameColumn('cantidad','stock');
        });
        
        
        Schema::table('ventas', function (Blueprint $table) {
            $table->renameColumn('precio_sin_tasas','precio');
            $table->renameColumn('total_tasas','iva');
        });

        Schema::table('compras', function (Blueprint $table) {
            $table->renameColumn('precio_sin_tasas','precio');
            $table->renameColumn('total_tasas','iva');
        });

        
        Schema::table('venta_lineas', function (Blueprint $table) {
             $table->string('unidad_mesura', 16);
        });

        
        Schema::table('compra_lineas', function (Blueprint $table) {
             $table->string('unidad_mesura', 16);
        });

        Schema::dropIfExists('empleados');
    }
}
