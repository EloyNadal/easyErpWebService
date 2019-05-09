<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\GrupoUsuario;

class GrupoUsuarioController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $grupo = GrupoUsuario::create($request->all());

        return $this->crearRespuesta('Grupo creado', $grupo, 201);
    }

    public function delete($id){

        $grupo = GrupoUsuario::where('id', $id)->first();

        if($grupo){
            $grupo->delete();
            return $this->crearRespuesta("GrupoUsuario $id eliminado", $grupo, 200);
        }
        else{
            return $this->crearRespuestaError("GrupoUsuario $id no existe", 404);
        }

    }

    public function read($id){
        
        $grupo = GrupoUsuario::where('id', $id)->first();

        if(!$grupo)
        {
            return $this->crearRespuestaError('GrupoUsuario no existe', 404);
        }
        return $this->crearRespuesta('GrupoUsuario encontrado', $grupo, 200);     

    }

    public function readAll(){

        $grupos = GrupoUsuario::all();
        return $this->crearRespuesta('GrupoUsuario encontrados', $grupos, 200);

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $grupo = GrupoUsuario::where('id', $id)->first();

        if (!$grupo)
        {
            return $this->crearRespuestaError("GrupoUsuario $id no existe", 404);   
        }
        
        $grupo->nombre = $request->input('nombre');
        $grupo->permiso = $request->input('permiso');

        $grupo->save();

        return $this->crearRespuesta("GrupoUsuario $id actualizada", $grupo, 200);        
    }

    public function validacion($request)
    {   

        $reglas = 
        [
            'nombre' => 'required',
            'permiso' => 'required',
        ];

        $this->validate($request, $reglas);
    }


}
