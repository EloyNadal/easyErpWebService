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

        $proveedores = Proveedor::all();
        return $this->crearRespuesta('Proveedores encontrados', $proveedores, 200);

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

        $proveedor = Proveedor::where($query)->get();
        
        if(!$proveedor)
        {
            return $this->crearRespuestaError('Proveedores no encontrados', 404);
        }
        return $this->crearRespuesta('Proveedores encontrados encontrados', $proveedor, 200);     

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
