<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
use App\Empleado;


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
        Empleado::truncate();
        
		factory(Empleado::class, 10)->create();
		factory(Cliente::class, 10)->create();
		
        $faker = Faker\Factory::create('es_ES');
        $tiendas = array('Sant Boi de Llobregat', 'Cornella', 'Castelldefels', 'Viladecans','Sant Vicenç dels Horts');
        $proveedores = array('Cobega SA', 'Nestle SA', 'Grup Aliment Barcelona SL', 'Taste of America SL', 'Komkal Mayorista SA', 'Primar Ibérica SA', 'Friman SL', 'Coseral SA');
        $productos = array('Cocacola', 'Agua Font Vella', 'Tomate frito', 'Natillas de vainilla', 'Pizza de jamon y queso', 'Conos de maiz', 'Chocolate con leche', 'Mayonesa Hellmann', 'Lenteja cocida', 'Aceite de girasol');

        foreach ($tiendas as $nombre) {
            
            DB::table('tiendas')->insert([
                'nombre' => $nombre,
                'direccion' => $faker->streetName,
                'ciudad' => $nombre,
                'telefono' => $faker->phoneNumber,
                'email' => $faker->email,
                'codigo_postal' => $faker->postcode,
                'pais' => 'España',
                'created_at' => date("Y-m-d H:i:s", time()),
                'updated_at' => date("Y-m-d H:i:s", time())
            ]);
        }

        foreach ($proveedores as $nombreProveedor) {
        
            DB::table('proveedores')->insert([    
                'nombre' => $nombreProveedor,
                'direccion' => $faker->streetName,
                'ciudad' => 'Barcelona',
                'telefono' => $faker->phoneNumber,
                'email' => $faker->email,
                'codigo_postal' => $faker->postcode,
                'pais' => 'España',
                'created_at' => date("Y-m-d H:i:s", time()),
                'updated_at' => date("Y-m-d H:i:s", time())
            ]);
        }

        DB::table('grupos_clientes')->insert([
            ['nombre' => 'premium', 'ratio_descuento' => 0.10],
            ['nombre' => 'porMayor', 'ratio_descuento' => 0.05],
            ['nombre' => 'defecto', 'ratio_descuento' => 0.00]
        ]);

        foreach ($productos as $pNombre) {
            
            DB::table('productos')->insert([
                'categoria_id' => $faker->numberBetween(1,6),
                'ean13' => $faker->ean13,
                'referencia' => substr($pNombre, 0, 3) . $faker->numberBetween(100,999),
                'nombre' => $pNombre,
                'unidad_mesura' => $faker->randomElement($array = array ('unidad','Kg','L')),
                'precio' => $faker->randomFloat(3, 0.00, 9.99),
                'tasa_id' => $faker->numberBetween(1,5),
                'stock_minimo' => $faker->randomFloat(3, 0, 10),
                'activo' => $faker->boolean,
                'fabricante' => $faker->word,
                'imagen' => $pNombre.'.jpg'
            ]);
        }
        factory(Producto::class, 3)->create();


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

        for ($i=0; $i < 10; $i++) { 
            
            $producto = true;
    
            while($producto){
                $proveedor_id = ($faker->numberBetween(1,8));
                $producto_id = $faker->numberBetween(1,10);
                $producto = App\ProductoProveedor::
                    where('producto_id', $producto_id)->first();
            }
            DB::table('producto_proveedores')->insert([
                'proveedor_id' => $proveedor_id, 
                'producto_id' => $producto_id,
            ]);
        }

        DB::table('tasas')->insert([
            ['nombre' => 'Sin iva' , 'ratio_tasa' => 0],
            ['nombre' => 'Iva 4%' , 'ratio_tasa' => 0.04],
            ['nombre' => 'Iva 8%' , 'ratio_tasa' => 0.08],
            ['nombre' => 'Iva 10%' , 'ratio_tasa' => 0.1],
            ['nombre' => 'Iva 21%' , 'ratio_tasa' => 0.21]
        ]);

        DB::table('compras')->insert([
            ['tienda_id' => 1, 'proveedor_id' => 1, 'precio_sin_tasas' => 10.00,
            'total_tasas' => 0.00, 'precio_total' => 10.00, 
            'created_at' => date("Y-m-d H:i:s", time()), 'updated_at' => date("Y-m-d H:i:s", time())
            ],

            ['tienda_id' => 1, 'proveedor_id' => 2, 'precio_sin_tasas' => 15.00,
            'total_tasas' => 0.00, 'precio_total' => 15.00,
            'created_at' => date("Y-m-d H:i:s", time()), 'updated_at' => date("Y-m-d H:i:s", time())],
            ['tienda_id' => 1, 'proveedor_id' => 2, 'precio_sin_tasas' => 6.00,
            'total_tasas' => 0.00, 'precio_total' => 6.00,
            'created_at' => date("Y-m-d H:i:s", time()), 'updated_at' => date("Y-m-d H:i:s", time())
            ],

            ['tienda_id' => 2, 'proveedor_id' => 1, 'precio_sin_tasas' => 34.00,
            'total_tasas' => 0.00, 'precio_total' => 34.00,
            'created_at' => date("Y-m-d H:i:s", time()), 'updated_at' => date("Y-m-d H:i:s", time())
            ],

            ['tienda_id' => 2, 'proveedor_id' => 3, 'precio_sin_tasas' => 5.46,
            'total_tasas' => 0.00, 'precio_total' => 5.46,
            'created_at' => date("Y-m-d H:i:s", time()), 'updated_at' => date("Y-m-d H:i:s", time())
            ]
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


        for($z = 0; $z < 2; $z++){

            $year = 0;
            if ($z == 0) $year = 365;

            for ($i=0; $i < 75; $i++) { 
            
            $tienda = $faker->numberBetween(1,5);
            $cliente = $faker->numberBetween(1,10);

            $day = $faker->numberBetween(1,31);
            
            $ventaID = DB::table('ventas')->insertGetId([
                'tienda_id' => $tienda,
                'cliente_id' => $cliente,
                'precio_sin_tasas' => 0,
                'total_tasas' => 0.00, 
                'precio_total' => 0.00,
                'tarjeta' => 1,
                'created_at' => date("Y-m-d H:i:s", time() - (($day + $year) * 24*60*60))
            ]);

            $lineas = $faker->numberBetween(1,5);
            $precios_SI = 0;
            $precio_total = 0;
            $total_tasas = 0;

            for ($x=0; $x < $lineas; $x++) { 
                
                $producto = Producto::where('id', $faker->numberBetween(1,10))->first();
                $cantidad = $faker->numberBetween(1,5);

                DB::table('venta_lineas')->insert([
                    'tienda_id' => $tienda, 
                    'venta_id' => $ventaID, 
                    'producto_id' => $producto['id'],
                    'precio' => $producto['precio'] * $cantidad, 
                    'tasa_id' => $producto['tasa_id'], 
                    'cantidad' => $cantidad
                ]);

                $tasa = Tasa::where('id', $producto['tasa_id'])->first();

                $precio_total += $producto['precio'] * $cantidad;
                $precios_SI += (($producto['precio'] * $cantidad) * 100) / (100 + $tasa['ratio_tasa'] * 100);
            }

            $total_tasas = $precio_total - $precios_SI;

            DB::table('ventas')
            ->where('id', $ventaID)
            ->update([
                'precio_sin_tasas' => $precios_SI,
                'total_tasas' => $total_tasas, 
                'precio_total' => $precio_total,
            ]);
            }

        }

        
        DB::table('categorias')->insert([
        	['nombre' => 'raiz' , 'categoria_id' => 0],
        	['nombre' => 'Bebida' , 'categoria_id' => 1],
        	['nombre' => 'Despensa' , 'categoria_id' => 1],
        	['nombre' => 'Fresco' , 'categoria_id' => 1],
        	['nombre' => 'Refresco' , 'categoria_id' => 2],
        	['nombre' => 'Cerveza' , 'categoria_id' => 2],
        	['nombre' => 'Patatas' , 'categoria_id' => 3],
            ['nombre' => 'Conservas' , 'categoria_id' => 3],
            ['nombre' => 'Fruta' , 'categoria_id' => 4],
            ['nombre' => 'Carne' , 'categoria_id' => 4]
        ]);

        DB::table('grupo_usuarios')->insert([
            ['nombre' => 'Administrador' , 'permiso' => 'W'],
            ['nombre' => 'Empleado' , 'permiso' => 'R']
        ]);

        DB::table('usuarios')->insert([
            ['empleado_id' => 2, 'user_name' => 'carlos',
            'password' => Hash::make('carlos'), 'grupo_usuario_id' => 2],

            ['empleado_id' => 3, 'user_name' => 'eloy',
            'password' => Hash::make('eloy'),'grupo_usuario_id' => 2],

            ['empleado_id' => 1, 'user_name' => 'admin',
            'password' => Hash::make('admin'), 'grupo_usuario_id' => 1]
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
