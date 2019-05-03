<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Compra;
use App\CompraLinea;
use App\Tienda;
use App\Proveedor;
use App\Stock;

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


        $compra = Compra::create([
            'tienda_id' => $tienda_id,
            'proveedor_id' => $proveedor_id,
            'precio' => $request->input('precio'),
            'iva' => $request->input('iva'),
            'precio_total' => $request->input('precio_total')
        ]);


        foreach ($request->input('compras_productos') as $linea) {
            
            $producto_id = $linea['producto_id'];

            $compra_producto = CompraLinea::create([
                'tienda_id' => $tienda_id,
                'compra_id' => $compra['id'],
                'producto_id' => $producto_id,
                'precio' => $linea['precio'],
                'tasa_id' => $linea['tasa_id'],
                'cantidad' => $linea['cantidad'],
                'unidad_mesura' => $linea['unidad_mesura']
            ]);

            $stock = Stock::where('tienda_id', $tienda_id)
                ->where('producto_id', $producto_id)
                ->first();
            
            $stock->increment('stock', $compra_producto['cantidad']);
            // $stock->stock += $compra_producto['cantidad'];
            //$stock->decrement
            $stock->save();

        }

        return $this->crearRespuesta('Compra creada', $compra, 200);
    }

    public function read($tienda_id, $id){
        
        $compra = Compra::where('tienda_id', $tienda_id)
            ->where('id', $id)
            ->first();

        if($compra)
        {
            $lineas = CompraLinea::where('tienda_id', $tienda_id)
                ->where('compra_id', $compra['id'])
                ->get();

                $compra->compra_linea = $lineas;
            
            return $this->crearRespuesta('Compra encontrado', $compra, 200);
        }
        else{

            return $this->crearRespuestaError('Compra no existe', 404);
        }

    }

    public function readAll($tienda_id){

        $compras = Compra::where('tienda_id', $tienda_id)
            ->get();

        if (sizeof($compras) > 0){

            foreach ($compras as $compra) {

                $lineas = CompraLinea::where('tienda_id', $tienda_id)
                ->where('compra_id', $compra['id'])
                ->get();

                $compra->compra_linea = $lineas;

            }
            return $this->crearRespuesta('Compras encontradas', $compras, 200);

        }else{
            return $this->crearRespuestaError('No existen compras', 404);
        }
        

    }

    public function validacion($request)
    {

        $reglas = 
            [   
            'tienda_id' => 'required',
            'proveedor_id' => 'required',
            'precio' => 'required',
            'iva' => 'required',
             'precio_total' => 'required'
        ];

        
        $this->validate($request, $reglas);
    }
}
