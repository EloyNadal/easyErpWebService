<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Venta;
use App\VentaLinea;
use App\Tienda;
use App\Producto;

class VentaController extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
    }

    public function read($id){
        
        $ventaLinea = Venta::where('id', $id)
            ->first();

        if($ventaLinea)
        {
            $ventaLinea->tienda = Tienda::where('id', $ventaLinea['tienda_id'])
                ->first();
            $ventaLinea->venta = Venta::where('id', $ventaLinea['venta_id'])
                ->first();
            $ventaLinea->producto = Producto::where('id', $ventaLinea['producto_id'])
                ->first();

            return $this->crearRespuesta('Venta encontrado', $ventaLinea, 200);
        }
        else{

            return $this->crearRespuestaError('Venta no existe', 404);
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

        $ventaLineas = Venta::where($query)->get();


        if (sizeof($ventaLineas) > 0){

            foreach ($ventaLineas as $ventaLinea) {
                
                $ventaLinea->tienda = Tienda::where('id', $ventaLinea['tienda_id'])
                    ->first();
                $ventaLinea->venta = Venta::where('id', $ventaLinea['venta_id'])
                    ->first();
                $ventaLinea->producto = Producto::where('id', $ventaLinea['producto_id'])
                  ->first();

            }
            return $this->crearRespuesta('Ventas encontradas', $ventas, 200);

        }else{
            return $this->crearRespuestaError('No existen ventas', 404);
        }

    }

    public function validacion($request)
    {
        
        $reglas = 
            [   
            'tienda_id' => 'required',
            'cliente_id' => 'required',
            'precio_sin_tasas' => 'required',
            'total_tasas' => 'required',
            'precio_total' => 'required'
        ];

        
        $this->validate($request, $reglas);
    }
}
