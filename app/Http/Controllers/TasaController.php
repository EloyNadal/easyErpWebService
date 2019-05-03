<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tasa;

class TasaController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $tasa = Tasa::create($request->all());

        return $this->crearRespuesta('Tasa creada', $tasa, 201);
    }

    public function delete($id){

        $tasa = Tasa::where('id', $id)->first();

        if($tasa){
            $tasa->delete();
            return $this->crearRespuesta("Tasa $id eliminado", $tasa, 200);
        }
        else{
            return $this->crearRespuestaError("Tasa $id no existe", 404);
        }

    }

    public function read($id){
        
        $tasa = Tasa::where('id', $id)->first();

        if(!$tasa)
        {
            return $this->crearRespuestaError('Tasa no existe', 404);
        }
        return $this->crearRespuesta('Tasa encontrado', $tasa, 200);     

    }

    public function readAll(){

        $tasas = Tasa::all();
        return $this->crearRespuesta('Tasa encontrados', $tasas, 200);

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $tasa = Tasa::where('id', $id)->first();

        if (!$tasa)
        {
            return $this->crearRespuestaError("Tasa $id no existe", 404);   
        }
        
        $tasa->nombre = $request->input('nombre');
        $tasa->direccion = $request->input('ratio_tasa');

        $tasa->save();

        return $this->crearRespuesta("Tasa $id actualizada", $tasa, 200);        
    }

    public function validacion($request)
    {   

        $reglas = 
        [
            'nombre' => 'required',
            'ratio_tasa' => 'required',
        ];

        $this->validate($request, $reglas);
    }


}
