<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Categoria;
use App\Cliente;
use App\Compra;
use App\CompraLinea;
use App\GrupoCliente;
use App\Producto;
use App\Proveedor;
use App\Tienda;
use App\Venta;
use App\VentaLinea;
use App\Stock;
use App\Tasa;
use App\Usuario;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Categoria::truncate();
		Cliente::truncate();
		Compra::truncate();
		CompraLinea::truncate();
		GrupoCliente::truncate();
		Producto::truncate();
		Proveedor::truncate();
		Tienda::truncate();
		Venta::truncate();
		VentaLinea::truncate();
		Stock::truncate();
		Tasa::truncate();
		Usuario::truncate();
		
		factory(Cliente::class, 10)->create();
		factory(Compra::class, 10)->create();
		factory(CompraLinea::class, 10)->create();
		factory(GrupoCliente::class, 10)->create();
		factory(Producto::class, 10)->create();
		factory(Proveedor::class, 10)->create();
		factory(Tienda::class, 10)->create();
		factory(Venta::class, 10)->create();
		factory(VentaLinea::class, 10)->create();
		factory(Stock::class, 10)->create();

		DB::table('usuarios')->insert([
            'nombre' => 'admin',
            'apellidos' => 'admin',
            'email' => 'admin@admin.es',
            'password' => 'admin',
            'admin' => 1,
            'tienda_id' => 0
        ]);

        DB::table('categorias')->insert([
        	['nombre' => 'raiz' , 'categoria_id' => 0],
        	['nombre' => 'Productos' , 'categoria_id' => 1],
        	['nombre' => 'Alimentación' , 'categoria_id' => 1],
        	['nombre' => 'Calzado' , 'categoria_id' => 2],
        	['nombre' => 'Ropa' , 'categoria_id' => 2],
        	['nombre' => 'Bebida' , 'categoria_id' => 3],
        	['nombre' => 'Comida' , 'categoria_id' => 3]
        ]);

        DB::table('tasas')->insert([
        	['nombre' => 'Sin iva' , 'ratio_tasa' => 0],
        	['nombre' => 'Iva 4%' , 'ratio_tasa' => 0.04],
        	['nombre' => 'Iva 8%' , 'ratio_tasa' => 0.08],
        	['nombre' => 'Iva 10%' , 'ratio_tasa' => 0.1],
        	['nombre' => 'Iva 21%' , 'ratio_tasa' => 0.21]
        ]);

        DB::table('grupo_usuarios')->insert([

            ['nombre' => 'Administrador' , 'permiso' => 'W'],
            ['nombre' => 'Empleado' , 'permiso' => 'R']
            
        ]);

    }
}
