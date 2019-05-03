<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tienda;

class TiendaController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $tienda = Tienda::create($request->all());

        return $this->crearRespuesta('Tienda creado', $tienda, 201);
    }

    public function delete($id){

        $tienda = Tienda::where('id', $id)->first();

        if($tienda){
            $tienda->delete();
            return $this->crearRespuesta("Tienda $id eliminado", $tienda, 200);
        }
        else{
            return $this->crearRespuestaError("Tienda $id no existe", 404);
        }

    }

    public function read($id){
        
        $tienda = Tienda::where('id', $id)->first();

        if(!$tienda)
        {
            return $this->crearRespuestaError('Tienda no existe', 404);
        }
        return $this->crearRespuesta('Tienda encontrado', $tienda, 200);     

    }

    public function readAll(){

        $tiendas = Tienda::all();
        return $this->crearRespuesta('Tienda encontrados', $tiendas, 200);

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $tienda = Tienda::where('id', $id)->first();

        if (!$tienda)
        {
            return $this->crearRespuestaError("Tienda $id no existe", 404);   
        }
        
        $tienda->nombre = $request->input('nombre');
        $tienda->direccion = $request->input('direccion');
        $tienda->ciudad = $request->input('ciudad');
        $tienda->telefono = $request->input('telefono');
        $tienda->email = $request->input('email');
        $tienda->codigo_postal = $request->input('codigo_postal');
        $tienda->pais = $request->input('pais');

        $tienda->save();

        return $this->crearRespuesta("Tienda $id actualizado", $tienda, 200);        
    }

    public function validacion($request)
    {   

        $reglas = 
        [
            'nombre' => 'required',
            'email' => 'required',
        ];

        $this->validate($request, $reglas);
    }


}
