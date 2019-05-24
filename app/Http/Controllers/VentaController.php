<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Venta;
use App\VentaLinea;
use App\Tienda;
use App\Cliente;
use App\Stock;

class VentaController extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);
        
        $tienda_id = $request->input('tienda_id');
        $cliente_id = $request->input('cliente_id');

        if(!Tienda::where('id', $tienda_id)->first())
        {
            return $this->crearRespuestaError('Tienda no existe', 404);
        }

        $venta = Venta::create([
            'tienda_id' => $tienda_id,
            'cliente_id' => $cliente_id,
            'precio_sin_tasas' => $request->input('precio_sin_tasas'),
            'total_tasas' => $request->input('total_tasas'),
            'precio_total' => $request->input('precio_total')
        ]);


        foreach ($request->input('venta_linea') as $linea) {
            
            $producto_id = $linea['producto_id'];

            $venta_linea = VentaLinea::create([
                'tienda_id' => $venta['tienda_id'],
                'venta_id' => $venta['id'],
                'producto_id' => $producto_id,
                'precio' => $linea['precio'],
                'tasa_id' => $linea['tasa_id'],
                'cantidad' => $linea['cantidad']
            ]);

            $stock = Stock::where('tienda_id', $tienda_id)
                ->where('producto_id', $producto_id)
                ->first();

            if(!$stock){
                $stock = StockController::create([
                    'tienda_id' => $tienda_id, 
                    'producto_id' => $producto_id,
                    'cantidad' => 0
                ]);
            }
            
            $stock->decrement('cantidad', $venta_linea['cantidad']);
            $stock->save();

        }

        return $this->crearRespuesta('Venta creada', $venta, 200);
    }

    public function read($id){
        
        $venta = Venta::where('id', $id)
            ->first();

        if($venta)
        {
            $lineas = VentaLinea::where('tienda_id', $venta['tienda_id'])
                ->where('venta_id', $venta['id'])
                ->get();

                $venta->venta_linea = $lineas;
            
            return $this->crearRespuesta('Venta encontrado', $venta, 200);
        }
        else{

            return $this->crearRespuestaError('Venta no existe', 404);
        }

    }

    public function readQuery(Request $request, $metodo){

        if ($request->input('producto_id')){
            return $this->crearRespuesta('Venta encontrado', $this::readByProduct($request), 200);
        }

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

        $ventas = Venta::where($query)->get();

        if (sizeof($ventas) > 0){

            foreach ($ventas as $venta) {

                $lineas = VentaLinea::where('tienda_id', $venta['tienda_id'])
                ->where('venta_id', $venta['id'])
                ->get();

                $venta->venta_linea = $lineas;

            }
            return $this->crearRespuesta('Ventas encontradas', $ventas, 200);

        }else{
            return $this->crearRespuestaError('No existen ventas', 404);
        }

    }

    public function readByProduct(Request $request){

        $producto_id = $request->input('producto_id');

        $ventas = Venta::join('venta_lineas', 'ventas.id', '=', 'venta_lineas.venta_id')
            ->select('ventas.*')
            ->where('venta_lineas.producto_id', $producto_id)
            ->get();

        //tengo las ventas con el prodcto;

        foreach ($ventas as $venta) {
            
            $linea = VentaLinea::where('venta_id', $venta['id'])
                ->where('producto_id', $producto_id)->get();
            $venta->venta_linea = $linea;
            $venta->tienda = Tienda::where('id', $venta['tienda_id'])->first();
        }


        return $ventas;

    }


    public function validacion($request)
    {
        
        $reglas = 
            [   
            'tienda_id' => 'required',
            'precio_sin_tasas' => 'required',
            'total_tasas' => 'required',
            'precio_total' => 'required'
        ];

        
        $this->validate($request, $reglas);
    }
}
