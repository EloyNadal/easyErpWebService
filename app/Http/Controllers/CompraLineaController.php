<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Compra;
use App\CompraLinea;
use App\Producto;
use App\Tienda;
use App\Proveedor;

class CompraLineaController extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readQuery']]);
        $this->middleware('admin', ['only' => ['update']]);

    }

    public function read($id){
        
        $compra_linea = Compralinea::where('id', $id)
                ->get();

        if($compra_linea)
        {
            return $this->crearRespuesta('Linea encontradas', $compra, 200);
        }
        else{
            return $this->crearRespuestaError('No existe', 404);
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

        $compra_lineas = Compralinea::where($query)->get();
        
        if(!$compra_lineas)
        {
            return $this->crearRespuestaError('Lineas de compra no encontrados', 404);
        }
        return $this->crearRespuesta('Lineas de compra encontradas', $compra_lineas, 200);
    }


    //$request= Array con los paramaetro id y cantidad de la linea
    //$compra_id = id de la compra
    public function update(Request $request, $compra_id){

        $compra = Compra::where('id', $compra_id)->first();

        if($compra){

            foreach ($request->input() as $linea) {
                
                Compralinea::where('id', $linea['id'])
                    ->update(['cantidad' => $linea['cantidad']]);
            
            }
            $compra_lineas = Compralinea::where('compra_id', $compra_id)->get();
            return $this->crearRespuesta('Lineas actualizadas', $compra_lineas, 200);
        }

        return $this->crearRespuestaError('Compra no existe', 404);        
    }

    public function validacion($request, $metodo)
    {   
        
        $reglas = null;
        if ($metodo == 'create')
        {
            $reglas = 
                [   
                'tienda_id' => 'required',
                'compra_id' => 'required',
                'producto_id' => 'required',
                'cantidad' => 'required'
            ];

        }elseif($metodo == 'update')
        {
            $reglas = 
            [   
                'precio' => 'required',
                'iva' => 'required'
            ];
        }

        $this->validate($request, $reglas);
    }
}
