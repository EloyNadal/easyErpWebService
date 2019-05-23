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
use App\CompraEstado;
use App\ProductoProveedor;
use App\GrupoUsuario;


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
        CompraEstado::truncate();
        ProductoProveedor::truncate();
        GrupoUsuario::truncate();
        
		
		factory(Cliente::class, 10)->create();
		factory(GrupoCliente::class, 10)->create();
		factory(Producto::class, 10)->create();
		factory(Proveedor::class, 10)->create();
		factory(Tienda::class, 10)->create();


        $faker = Faker\Factory::create('es_ES');
        for ($i=0; $i < 30; $i++) { 
            
            $stock = true;
    
            while($stock){
                $tienda_id = ($faker->numberBetween(1,5));
                $producto_id = $faker->numberBetween(1,10);
                $stock = App\Stock::where('tienda_id', $tienda_id)
                    ->where('producto_id', $producto_id)->first();
            }
            DB::table('stocks')->insert([
                'tienda_id' => $tienda_id, 
                'producto_id' => $producto_id,
                'cantidad' => $faker->numberBetween(1,100)
            ]);
        }

        for ($i=0; $i < 20; $i++) { 
            
            $proveedor = true;
    
            while($proveedor){
                $proveedor_id = ($faker->numberBetween(1,5));
                $producto_id = $faker->numberBetween(1,10);
                $proveedor = App\ProductoProveedor::
                    where('proveedor_id', $proveedor_id)
                    ->where('producto_id', $producto_id)->first();
            }
            DB::table('producto_proveedores')->insert([
                'proveedor_id' => $proveedor_id, 
                'producto_id' => $producto_id,
            ]);
        }




        DB::table('compras')->insert([
            ['tienda_id' => 1, 'proveedor_id' => 1, 'precio_sin_tasas' => 10.00,
            'total_tasas' => 0.00, 'precio_total' => 10.00],

            ['tienda_id' => 1, 'proveedor_id' => 2, 'precio_sin_tasas' => 15.00,
            'total_tasas' => 0.00, 'precio_total' => 15.00],

            ['tienda_id' => 1, 'proveedor_id' => 2, 'precio_sin_tasas' => 6.00,
            'total_tasas' => 0.00, 'precio_total' => 6.00],

            ['tienda_id' => 2, 'proveedor_id' => 1, 'precio_sin_tasas' => 34.00,
            'total_tasas' => 0.00, 'precio_total' => 34.00],

            ['tienda_id' => 2, 'proveedor_id' => 3, 'precio_sin_tasas' => 5.46,
            'total_tasas' => 0.00, 'precio_total' => 5.46]
        ]);

        DB::table('compra_lineas')->insert([

            ['tienda_id' => 1, 'compra_id' => 1, 'producto_id' => 1,
            'precio' => 8.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'compra_id' => 1, 'producto_id' => 2,
            'precio' => 5.00, 'tasa_id' => 1, 'cantidad' => 3],

            ['tienda_id' => 1, 'compra_id' => 1, 'producto_id' => 5,
            'precio' => 2.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'compra_id' => 2, 'producto_id' => 3,
            'precio' => 15.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'compra_id' => 3, 'producto_id' => 1,
            'precio' => 5.00, 'tasa_id' => 1, 'cantidad' => 6],

            ['tienda_id' => 1, 'compra_id' => 3, 'producto_id' => 4,
            'precio' => 1.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 5,
            'precio' => 6.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 3,
            'precio' => 6.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 2,
            'precio' => 10.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 1,
            'precio' => 12.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 5, 'producto_id' => 3,
            'precio' => 2.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 5, 'producto_id' => 1,
            'precio' => 3.46, 'tasa_id' => 1, 'cantidad' => 1]

        ]);

        DB::table('ventas')->insert([
            ['tienda_id' => 1, 'cliente_id' => 1, 'usuario_id' => 3,
            'precio_sin_tasas' => 10.00,
            'total_tasas' => 0.00, 'precio_total' => 10.00,
            'created_at' => date("Y-m-d H:i:s", time() - (365 * 24*60*60))],

            ['tienda_id' => 1, 'cliente_id' => 2, 'usuario_id' => 3,
            'precio_sin_tasas' => 15.00,
            'total_tasas' => 0.000, 'precio_total' => 15.00,
            'created_at' => date("Y-m-d H:i:s", time() - (365 * 24*60*60))],

            ['tienda_id' => 1, 'cliente_id' => 2, 'usuario_id' => 3,
            'precio_sin_tasas' => 6.00,
            'total_tasas' => 0.00, 'precio_total' => 6.00,
            'created_at' => date("Y-m-d H:i:s", time() - (365 * 24*60*60))],

            ['tienda_id' => 2, 'cliente_id' => 1, 'usuario_id' => 3,
             'precio_sin_tasas' => 34.00,
            'total_tasas' => 0.00, 'precio_total' => 34.00,
            'created_at' => date("Y-m-d H:i:s", time() - (365 * 24*60*60))],

            ['tienda_id' => 2, 'cliente_id' => 3, 'usuario_id' => 3,
            'precio_sin_tasas' => 5.46,
            'total_tasas' => 0.00, 'precio_total' => 5.46,
            'created_at' => date("Y-m-d H:i:s", time() - (365 * 24*60*60))],
//
            ['tienda_id' => 1, 'cliente_id' => 1, 'usuario_id' => 3,
            'precio_sin_tasas' => 10.00,
            'total_tasas' => 0.00, 'precio_total' => 10.00,
            'created_at' => date("Y-m-d H:i:s", time() - (7 * 24*60*60))],

            ['tienda_id' => 1, 'cliente_id' => 2, 'usuario_id' => 3,
            'precio_sin_tasas' => 15.00,
            'total_tasas' => 0.00, 'precio_total' => 15.00,
            'created_at' => date("Y-m-d H:i:s" , time() - (4 * 24*60*60))],

            ['tienda_id' => 1, 'cliente_id' => 2, 'usuario_id' => 3,
            'precio_sin_tasas' => 6.00,
            'total_tasas' => 0.00, 'precio_total' => 6.00,
            'created_at' => date("Y-m-d H:i:s", time() - (4 * 24*60*60))],

            ['tienda_id' => 2, 'cliente_id' => 1, 'usuario_id' => 3,
             'precio_sin_tasas' => 34.00,
            'total_tasas' => 0.00, 'precio_total' => 34.00,
            'created_at' => date("Y-m-d H:i:s", time() - (2 * 24*60*60))],

            ['tienda_id' => 2, 'cliente_id' => 3, 'usuario_id' => 3,
            'precio_sin_tasas' => 5.46,
            'total_tasas' => 0.00, 'precio_total' => 5.46,
            'created_at' => date("Y-m-d H:i:s")],
        ]);

        DB::table('venta_lineas')->insert([

            ['tienda_id' => 1, 'venta_id' => 1, 'producto_id' => 1,
            'precio' => 8.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 1, 'producto_id' => 2,
            'precio' => 5.00, 'tasa_id' => 1, 'cantidad' => 3],

            ['tienda_id' => 1, 'venta_id' => 1, 'producto_id' => 5,
            'precio' => 2.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 2, 'producto_id' => 3,
            'precio' => 15.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 3, 'producto_id' => 1,
            'precio' => 5.00, 'tasa_id' => 1, 'cantidad' => 6],

            ['tienda_id' => 1, 'venta_id' => 3, 'producto_id' => 4,
            'precio' => 1.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 5,
            'precio' => 6.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 3,
            'precio' => 6.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 2,
            'precio' => 10.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 1,
            'precio' => 12.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 5, 'producto_id' => 3,
            'precio' => 2.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 5, 'producto_id' => 1,
            'precio' => 3.46, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 6, 'producto_id' => 1,
            'precio' => 8.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 6, 'producto_id' => 2,
            'precio' => 5.00, 'tasa_id' => 1, 'cantidad' => 3],

            ['tienda_id' => 1, 'venta_id' => 6, 'producto_id' => 5,
            'precio' => 2.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 7, 'producto_id' => 3,
            'precio' => 15.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 8, 'producto_id' => 1,
            'precio' => 5.00, 'tasa_id' => 1, 'cantidad' => 6],

            ['tienda_id' => 1, 'venta_id' => 8, 'producto_id' => 4,
            'precio' => 1.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 9, 'producto_id' => 5,
            'precio' => 6.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 9, 'producto_id' => 3,
            'precio' => 6.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 9, 'producto_id' => 2,
            'precio' => 10.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 9, 'producto_id' => 1,
            'precio' => 12.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 10, 'producto_id' => 3,
            'precio' => 2.00, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 10, 'producto_id' => 1,
            'precio' => 3.46, 'tasa_id' => 1, 'cantidad' => 1]

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

        DB::table('usuarios')->insert([
            ['empleado_id' => 2, 'user_name' => 'carlos',
            'password' => 'carlos', 'grupo_usuario_id' => 2],

            ['empleado_id' => 3, 'user_name' => 'eloy',
            'password' => 'eloy','grupo_usuario_id' => 2],

            ['empleado_id' => 1, 'user_name' => 'admin',
            'password' => 'admin', 'grupo_usuario_id' => 1]
        ]);

        DB::table('compra_estados')->insert([
            ['compra_id' => 1 , 'estado' => 'creado'],
            ['compra_id' => 2 , 'estado' => 'creado'],
            ['compra_id' => 3 , 'estado' => 'enviado'],
            ['compra_id' => 4 , 'estado' => 'recibido'],
            ['compra_id' => 5 , 'estado' => 'finalizado'],
        ]);

    }
}
