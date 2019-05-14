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

    public function create(Request $request){

        $stock = Stock::create(
            'tienda_id' => $tienda_id,
            'producto_id' => $producto_id,
            'cantidad' => 0
        );

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
        return $this->crearRespuesta('Stock encontrado', $tienda, 200);

    }

    public function readAll(){

        $stock = Stock::all();
        if(!$stock){
            return $this->crearRespuestaError("Sin stocks credos", 404);   
        }
        return $this->crearRespuesta('Stocks encontrados', $stock, 200);

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

        $stock = Stock::where($query)->get();
        
        if(!$stock)
        {
            return $this->crearRespuestaError('Stocks no encontrados', 404);
        }
        return $this->crearRespuesta('Stocks encontrados', $proveedor, 200);     

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
