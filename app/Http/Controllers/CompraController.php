<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Compra;
use App\CompraLinea;
use App\Tienda;
use App\Proveedor;
use App\Stock;
use App\CompraEstado;
use App\Producto;

class CompraController extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);
        
        $tienda_id = $request->input('tienda_id');
        $proveedor_id = $request->input('proveedor_id');

        if(!Tienda::where('id', $tienda_id)->first())
        {
            return $this->crearRespuestaError('Tienda no existe', 404);
        }

        if(!Proveedor::where('id', $proveedor_id)->first())
        {
            return $this->crearRespuestaError('Proveedor no existe', 404);
        }

        $compra;

        
        $compra = Compra::create([
            'tienda_id' => $tienda_id,
            'proveedor_id' => $proveedor_id,
            'precio_sin_tasas' => $request->input('precio_sin_tasas'),
            'total_tasas' => $request->input('total_tasas'),
            'precio_total' => $request->input('precio_total')
        ]);


        foreach ($request->input('compra_linea') as $linea) {
            
            $producto_id = $linea['producto_id'];

            $compra_producto = CompraLinea::create([
                'tienda_id' => $compra['tienda_id'],
                'compra_id' => $compra['id'],
                'producto_id' => $producto_id,
                'precio' => $linea['precio'],
                'tasa_id' => $linea['tasa_id'],
                'cantidad' => $linea['cantidad']
            ]);

        }
        $estado = CompraEstado::create([
                'compra_id' => $compra['id'],
                'estado' => 'creado'
            ]);

        return $this->crearRespuesta('Compra creada', $compra, 200);
    }


    public function read($id){
        
        $compra = Compra::where('id', $id)
            ->first();

        if($compra)
        {
            $lineas = CompraLinea::where('tienda_id', $compra['tienda_id'])
                ->where('compra_id', $compra['id'])
                ->get();

            $compra->compra_linea = $lineas;

            foreach ($lineas as $linea) {
                    
                    $producto = Producto::where('id', $linea['producto_id'])
                        ->first();

                    $linea->productoNombre = $producto['nombre'];
                    $linea->productoEan13 = $producto['ean13'];

            }


            $estado = CompraEstado::select('estado')
                ->where('compra_id', $compra['id'])->first();
            if ($estado){
                $compra->estado = $estado['estado'];
            }

            $proveedor = Proveedor::where('id', $compra['proveedor_id'])
                    ->first();
            if($proveedor){
                $compra->proveedor = $proveedor;  
            }
            
            return $this->crearRespuesta('Compra encontrado', $compra, 200);
        }
        else{

            return $this->crearRespuestaError('Compra no existe', 404);
        }

    }

    public function readQuery(Request $request, $metodo){

        $query = array();
        $condicion = ($metodo == 0) ? "and" : "or";

        foreach ($request->input() as $key => $value) {

                if (is_numeric($value)){
                    $queryvalue = [$key, '=', $value, $condicion];    
                }
                else{
                    $queryvalue = [$key, 'LIKE', "%$value%", $condicion];       
                }
                
                array_push($query, $queryvalue);
        }   

        $compras = Compra::where($query)->get();

        if (sizeof($compras) > 0){

            foreach ($compras as $compra) {

                $lineas = CompraLinea::where('tienda_id', $compra['tienda_id'])
                ->where('compra_id', $compra['id'])
                ->get();

                foreach ($lineas as $linea) {
                    
                    $producto = Producto::where('id', $linea['producto_id'])
                        ->first();

                    $linea->productoNombre = $producto['nombre'];
                    $linea->productoEan13 = $producto['ean13'];

                }

                $compra->compra_linea = $lineas;

                $estado = CompraEstado::select('estado')
                    ->where('compra_id', $compra['id'])->first();
                if ($estado){
                    $compra->estado = $estado['estado'];
                }

                $proveedor = Proveedor::where('id', $compra['proveedor_id'])
                    ->first();
                if($proveedor){
                    $compra->proveedor = $proveedor;  
                }

            }



            return $this->crearRespuesta('Compras encontradas', $compras, 200);

        }else{
            return $this->crearRespuestaError('No existen compras', 404);
        }
    }

    public function update(Request $request, $id){

        $compra = Compra::where('id', $id)->first();

        if ($compra)
        {
            $newEstado = $request->input('estado');
            if ($newEstado)
            {
                $oldEstado = CompraEstado::where('compra_id', $id)
                    ->first();
                if ($oldEstado)
                {
                    if ($newEstado == 'finalizado' && $oldEstado['estado'] != $newEstado)
                    {
                        $compra_lineas = CompraLinea::where('compra_id', $id)
                            ->get();


                        foreach ($compra_lineas as $linea) 
                        {
                            $stock = Stock::where('tienda_id', $linea['tienda_id'])
                                ->where('producto_id', $linea['producto_id'])
                                ->first();

                            if(!$stock){
                               $stock = Stock::create([
                                    'tienda_id' => $linea['tienda_id'], 
                                    'producto_id' => $linea['producto_id'],
                                    'cantidad' => 0
                                ]);
                            }
            
                            $stock->increment('cantidad', $linea['cantidad']);
                            $stock->save();
                        }
                    }

                    $oldEstado['estado'] = $newEstado;
                    $oldEstado->save();
                    $compra->estado = $oldEstado['estado'];
                }
                else{

                    $newEstado = CompraEstado::create([
                        'compra_id' => $compra['id'],
                        'estado' => $request->input('estado')
                    ]);

                    $compra->estado = $oldEstado['estado'];   

                }

            }
            return $this->crearRespuesta('Compra actualizada', $compra, 200);

        }
        else{

            return $this->crearRespuestaError('Compra no existe', 404);
        }
    }


    public function validacion($request)
    {

        $reglas = 
            [   
            'tienda_id' => 'required',
            'proveedor_id' => 'required',
            'precio_sin_tasas' => 'required',
            'total_tasas' => 'required',
             'precio_total' => 'required'
        ];

        
        $this->validate($request, $reglas);
    }
}
