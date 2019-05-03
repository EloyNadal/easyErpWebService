<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\GrupoCliente;

class GrupoClienteController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $grupo_cliente = GrupoCliente::create($request->all());

        return $this->crearRespuesta('Grupo de clientes creado', $grupo_cliente, 201);
    }

    public function delete($id){

        $grupo_cliente = GrupoCliente::where('id', $id)->first();

        if($grupo_cliente){
            $grupo_cliente->delete();
            return $this->crearRespuesta("Grupo de clientes $id eliminado", $grupo_cliente, 200);
        }
        else{
            return $this->crearRespuestaError("Grupo de clientes $id no existe", 404);
        }

    }

    public function read($id){
        
        $grupo_cliente = GrupoCliente::where('id', $id)->first();

        if(!$grupo_cliente)
        {
            return $this->crearRespuestaError('Grupo de clientes no existe', 404);
        }
        return $this->crearRespuesta('Grupo de clientes encontrado', $grupo_cliente, 200);     

    }

    public function readAll(){

        $grupo_clientes = GrupoCliente::all();
        return $this->crearRespuesta('Grupo de clientes encontrados', $grupo_clientes, 200);

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $grupo_cliente = GrupoCliente::where('id', $id)->first();

        if (!$grupo_cliente)
        {
            return $this->crearRespuestaError("Grupo de clientes $id no existe", 404);   
        }

        $grupo_cliente->nombre = $request->input('nombre');
        $grupo_cliente->ratio_descuento = $request->input('ratio_descuento');

        $grupo_cliente->save();

        return $this->crearRespuesta("Grupo de clientes $id actualizado", $grupo_cliente, 200);        
    }

    public function validacion($request)
    {   

        $reglas = 
        [
            'nombre' => 'required',
            'ratio_descuento' => 'required',
        ];

        $this->validate($request, $reglas);
    }


}
