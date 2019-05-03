<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Proveedor;

class ProveedorController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $proveedor = Proveedor::create($request->all());

        return $this->crearRespuesta('Proveedor creado', $proveedor, 201);
    }

    public function delete($id){

        $proveedor = Proveedor::where('id', $id)->first();

        if($proveedor){
            $proveedor->delete();
            return $this->crearRespuesta("Proveedor $id eliminado", $proveedor, 200);
        }
        else{
            return $this->crearRespuestaError("Proveedor $id no existe", 404);
        }

    }

    public function read($id){
        
        $proveedor = Proveedor::where('id', $id)->first();

        if(!$proveedor)
        {
            return $this->crearRespuestaError('Proveedor no existe', 404);
        }
        return $this->crearRespuesta('Proveedor encontrado', $proveedor, 200);     

    }

    public function readAll(){

        $proveedors = Proveedor::all();
        return $this->crearRespuesta('Proveedor encontrados', $proveedors, 200);

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $proveedor = Proveedor::where('id', $id)->first();

        if (!$proveedor)
        {
            return $this->crearRespuestaError("Proveedor $id no existe", 404);   
        }
        
        $proveedor->nombre = $request->input('nombre');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->ciudad = $request->input('ciudad');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->email = $request->input('email');
        $proveedor->codigo_postal = $request->input('codigo_postal');
        $proveedor->pais = $request->input('pais');

        $proveedor->save();

        return $this->crearRespuesta("Proveedor $id actualizado", $proveedor, 200);        
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
