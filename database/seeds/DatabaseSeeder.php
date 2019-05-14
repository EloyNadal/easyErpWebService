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
		factory(Stock::class, 10)->create();
        factory(ProductoProveedor::class, 10)->create();


        DB::table('compras')->insert([
            ['tienda_id' => 1, 'proveedor_id' => 1, 'precio_sin_tasas' => 10.000,
            'total_tasas' => 0.000, 'precio_total' => 10.000],

            ['tienda_id' => 1, 'proveedor_id' => 2, 'precio_sin_tasas' => 15.000,
            'total_tasas' => 0.000, 'precio_total' => 15.000],

            ['tienda_id' => 1, 'proveedor_id' => 2, 'precio_sin_tasas' => 6.000,
            'total_tasas' => 0.000, 'precio_total' => 6.000],

            ['tienda_id' => 2, 'proveedor_id' => 1, 'precio_sin_tasas' => 34.000,
            'total_tasas' => 0.000, 'precio_total' => 34.000],

            ['tienda_id' => 2, 'proveedor_id' => 3, 'precio_sin_tasas' => 5.460,
            'total_tasas' => 0.000, 'precio_total' => 5.460]
        ]);

        DB::table('compra_lineas')->insert([

            ['tienda_id' => 1, 'compra_id' => 1, 'producto_id' => 1,
            'precio' => 8.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'compra_id' => 1, 'producto_id' => 2,
            'precio' => 5.000, 'tasa_id' => 1, 'cantidad' => 3],

            ['tienda_id' => 1, 'compra_id' => 1, 'producto_id' => 5,
            'precio' => 2.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'compra_id' => 2, 'producto_id' => 3,
            'precio' => 15.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'compra_id' => 3, 'producto_id' => 1,
            'precio' => 5.000, 'tasa_id' => 1, 'cantidad' => 6],

            ['tienda_id' => 1, 'compra_id' => 3, 'producto_id' => 4,
            'precio' => 1.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 5,
            'precio' => 6.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 3,
            'precio' => 6.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 2,
            'precio' => 10.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 4, 'producto_id' => 1,
            'precio' => 12.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 5, 'producto_id' => 3,
            'precio' => 2.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'compra_id' => 5, 'producto_id' => 1,
            'precio' => 3.460, 'tasa_id' => 1, 'cantidad' => 1]

        ]);

        DB::table('ventas')->insert([
            ['tienda_id' => 1, 'cliente_id' => 1, 'usuario_id' => 3,
            'precio_sin_tasas' => 10.000,
            'total_tasas' => 0.000, 'precio_total' => 10.000],

            ['tienda_id' => 1, 'cliente_id' => 2, 'usuario_id' => 3,
            'precio_sin_tasas' => 15.000,
            'total_tasas' => 0.000, 'precio_total' => 15.000],

            ['tienda_id' => 1, 'cliente_id' => 2, 'usuario_id' => 3,
            'precio_sin_tasas' => 6.000,
            'total_tasas' => 0.000, 'precio_total' => 6.000],

            ['tienda_id' => 2, 'cliente_id' => 1, 'usuario_id' => 3,
             'precio_sin_tasas' => 34.000,
            'total_tasas' => 0.000, 'precio_total' => 34.000],

            ['tienda_id' => 2, 'cliente_id' => 3, 'usuario_id' => 3,
            'precio_sin_tasas' => 5.460,
            'total_tasas' => 0.000, 'precio_total' => 5.460]
        ]);

        DB::table('venta_lineas')->insert([

            ['tienda_id' => 1, 'venta_id' => 1, 'producto_id' => 1,
            'precio' => 8.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 1, 'producto_id' => 2,
            'precio' => 5.000, 'tasa_id' => 1, 'cantidad' => 3],

            ['tienda_id' => 1, 'venta_id' => 1, 'producto_id' => 5,
            'precio' => 2.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 2, 'producto_id' => 3,
            'precio' => 15.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 1, 'venta_id' => 3, 'producto_id' => 1,
            'precio' => 5.000, 'tasa_id' => 1, 'cantidad' => 6],

            ['tienda_id' => 1, 'venta_id' => 3, 'producto_id' => 4,
            'precio' => 1.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 5,
            'precio' => 6.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 3,
            'precio' => 6.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 2,
            'precio' => 10.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 4, 'producto_id' => 1,
            'precio' => 12.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 5, 'producto_id' => 3,
            'precio' => 2.000, 'tasa_id' => 1, 'cantidad' => 1],

            ['tienda_id' => 2, 'venta_id' => 5, 'producto_id' => 1,
            'precio' => 3.460, 'tasa_id' => 1, 'cantidad' => 1]
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
