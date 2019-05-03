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
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function read($tienda_id, $compra_id){
        
        $compra_linea = Compralinea::where('tienda_id', $tienda_id)
                ->where('compra_id', $compra_id)
                ->get();

        if($compra_linea)
        {
            return $this->crearRespuesta('Lineas encontradas', $compra, 200);
        }
        else{
            return $this->crearRespuestaError('No existen', 404);
        }

    }

    public function readAll($tienda_id){

        $compra_linea = Compralinea::where('tienda_id', $tienda_id)
                ->get();

        if($compra_linea)
        {
            return $this->crearRespuesta('Lineas encontradas', $compra, 200);
        }
        else{
            return $this->crearRespuestaError('No existen', 404);
        }
        
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
