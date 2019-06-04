<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Venta;
use App\VentaLinea;
use App\Tienda;
use App\Producto;

class VentaLineaController extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readQuery']]);
    }

    public function read($id){
        
        $ventaLinea = VentaLinea::where('id', $id)
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

    public function readByProduct(Request $request){

        $producto_id = $request->header("producto_id");
        $desde = $request->header("desde");
        $hasta = $request->header("hasta");
        $tienda_id = $request->header("tienda_id");

        if(!$producto_id) $producto_id ='';
        if(!$desde) $desde = '1900-01-01 00:00:00';
        if (!$hasta) $hasta = '2999-12-31 00:00.00';

        if(!$tienda_id)
        {
            $ventaLineas = $this->groupBySinTienda($producto_id, $desde, $hasta);
        }else
        {
            $ventaLineas = $this->groupByConTienda($producto_id, $desde, $hasta, $tienda_id);
        }
        
        if (sizeof($ventaLineas) > 0)
        {
            foreach ($ventaLineas as $ventaLinea) 
            {
                $ventaLinea->tienda = Tienda::where('id', $ventaLinea['tienda_id'])
                    ->first();
            }
            return $this->crearRespuesta('Ventas encontradas', $ventaLineas, 200);

        }
        else
        {
            return $this->crearRespuestaError('No existen ventas', 404);
        }

    }

    public function groupBySinTienda($producto_id, $desde, $hasta){
        $resultado = VentaLinea::join('ventas', 'venta_lineas.venta_id', '=', 'ventas.id')
            ->select('venta_lineas.tienda_id', 'venta_lineas.producto_id',DB::raw('sum(venta_lineas.precio) AS precio'), DB::raw('sum(venta_lineas.cantidad) AS cantidad'))
            ->where('venta_lineas.producto_id', $producto_id)
            ->where('ventas.created_at', '>', $desde)
            ->where('ventas.created_at', '<', $hasta)
            ->groupBy('venta_lineas.tienda_id', 'venta_lineas.producto_id')
            ->get();

        return $resultado;
    }

    public function groupByConTienda($producto_id, $desde, $hasta, $tienda_id){
        $resultado = VentaLinea::join('ventas', 'venta_lineas.venta_id', '=', 'ventas.id')
            ->select('venta_lineas.tienda_id', 'venta_lineas.producto_id',DB::raw('sum(venta_lineas.precio) AS precio'), DB::raw('sum(venta_lineas.cantidad) AS cantidad'))
            ->where('venta_lineas.producto_id', $producto_id)
            ->where('venta_lineas.tienda_id', '=', $tienda_id)
            ->where('ventas.created_at', '>', $desde)
            ->where('ventas.created_at', '<', $hasta)
            ->groupBy('venta_lineas.tienda_id', 'venta_lineas.producto_id')
            ->get();

        return $resultado;
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

        $ventaLineas = VentaLinea::where($query)->get();


        if (sizeof($ventaLineas) > 0){

            foreach ($ventaLineas as $ventaLinea) {
                
                $ventaLinea->tienda = Tienda::where('id', $ventaLinea['tienda_id'])
                    ->first();
                $ventaLinea->venta = Venta::where('id', $ventaLinea['venta_id'])
                    ->first();
                $ventaLinea->producto = Producto::where('id', $ventaLinea['producto_id'])
                  ->first();

            }
            return $this->crearRespuesta('Ventas encontradas', $ventaLineas, 200);

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
