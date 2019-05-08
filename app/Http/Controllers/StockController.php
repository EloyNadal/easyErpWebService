<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Stock;
use App\Tienda;
use App\Producto;

class StockController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['readAllOneShop', 'readAllShops']]);
        $this->middleware('admin', ['only' => ['createAll', 'delete', 'update']]);
    }

    public function create($tienda_id, $producto_id){

        $stock = Stock::create(
            'tienda_id' => $tienda_id,
            'producto_id' => $producto_id,
            'cantidad' => 0
        );
    }

    public function createAll(Request $request){

        //$this->validacion($request);
        foreach ($request['stocks'] as $stocks) 
        {
            $stock = Stock::where('tienda_id', $stocks['tienda_id'])
                ->where('producto_id', $stocks['producto_id'])
                ->first();

            if ($stock)
            {
                $stock->stock = $stocks['cantidad'];
            }
            else{
                $stock = Stock::create($stocks->all());    
            }
        }

        return $this->crearRespuesta('Stock almacenado', $stocks, 201);
    }

    public function read($tienda_id, $producto_id){
        
        $stock = Stock::where('tienda_id', $tienda_id)
                ->where('producto_id', $producto_id)
                ->first();

        if(!$stock)
        {
            return $this->crearRespuestaError('El producto no contiene datos en esta tienda', 404);
        }
        return $this->crearRespuesta('Stock encontrado', $tienda, 200);

    }

    public function readAllShops(){

        $stock = Stock::all();
        return $this->crearRespuesta('Stocks encontrados', $stock, 200);

    }

    public function readAllOneShop($tienda_id){

        $stocks = Stock::$stock = Stock::where('tienda_id', $tienda_id)->get();
        return $this->crearRespuesta('Stocks encontrados', $stocks, 200);

    }

    public function update(Request $request){

        $this->validacion($request);
        
        $tienda_id = $request->input('tienda_id');
        if(!Tienda::where('id', $tienda_id)->first())
        {
            return $this->crearRespuestaError("Tienda $tienda_id no existe", 404);
        }

        $producto_id = $request->input('producto_id');
        if(!Producto::where('id', $producto_id)->first())
        {
            return $this->crearRespuestaError("Tienda $producto_id no existe", 404);
        }

        $stock = Stock::where('tienda_id', $tienda_id)
                ->where('producto_id', $producto_id)
                ->first();

        if($stock)
        {
            $stock->stock += $request->input('cantidad');
            $stock->save();

        }else{
            $stock = Stock::create($request->all());
        }

        return $this->crearRespuesta("Stock actualizado", $stock, 200);        
    }

    public function validacion($request)
    {   
        
        $reglas = 
        [
            'tienda_id' => 'required',
            'producto_id' => 'required'
        ];

        $this->validate($request, $reglas);
    }


}
