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
        $this->middleware('auth', ['only' => ['read', 'readAll', 'readQuery']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $stock = Stock::create($request->all());

        return $this->crearRespuesta('Stock almacenado', $stock, 201);
    }

    //recibe array de stocks
    public function createAll(Request $request){

        //$this->validacion($request);
        foreach ($request->input() as $stocks) 
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

    public function read($id){
        
        $stock = Stock::where('id', $id)
                ->first();

        if(!$stock)
        {
            return $this->crearRespuestaError('El producto no contiene datos', 404);
        }
        $stock->tienda = Tienda::where('id', $stock['tienda_id'])->first();
        $stock->producto = Producto::where('id', $stock['producto_id'])->first();
        return $this->crearRespuesta('Stock encontrado', $stock, 200);

    }

    public function readAll(){

        $stocks = Stock::all();
        if(!$stock){
            return $this->crearRespuestaError("Sin stocks credos", 404);   
        }

        foreach ($stock as $stock) {
            
            $stock->tienda = Tienda::where('id', $stock['tienda_id'])->first();
            $stock->producto = Producto::where('id', $stock['producto_id'])->first();
        }

        return $this->crearRespuesta('Stocks encontrados', $stocks, 200);

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

        $stocks = Stock::where($query)->get();
        
        if(sizeof($stocks) < 0)
        {   
            return $this->crearRespuestaError('Stocks no encontrados', 404);
        }
        
        foreach ($stocks as $stock) {

            $tienda = Tienda::where('id', $stock['tienda_id'])->first();
            $stock->tienda = $tienda;
            $producto = Producto::where('id', $stock['producto_id'])->first();
            $stock->producto = $producto;
            
        }


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
            $stock->stock = $request->input('cantidad');
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
