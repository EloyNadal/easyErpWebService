<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CompraEstado;
use App\Compra;

class CompraEstadoController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $compra = Compra::where('id', $request->input('compra_id'))->first();

        if(!$compra)
        {
            return $this->crearRespuestaError('Id de compra no existe', 404);
        }


        $compra_estado = CompraEstado::create($request->all());
        return $this->crearRespuesta('Estado creada', $compra_estado, 201);
    }

    public function delete($id){

        $compra_estado = CompraEstado::where('id', $id)->first();

        if($compra_estado){
            $compra_estado->delete();
            return $this->crearRespuesta('Estado eliminado', $compra_estado, 200);
        }
        else{
            return $this->crearRespuestaError('Estado no existe', 404);
        }

    }

    public function read($id){
        
        $compra_estado = CompraEstado::where('id', $id)->first();

        if($compra_estado){
            return $this->crearRespuesta('Estado encontrado', $compra_estado, 200);
        }
        else{
            return $this->crearRespuestaError('Estado no existe', 404);
        }        

    }

    public function readAll(){

        $compra_estado = CompraEstado::all();
        return $this->crearRespuesta('Estados encontrados', $compra_estado, 200);
    }

    public function update(Request $request, $id){

        $this->validacion($request);

        $compra = Compra::where('id', $request->input('compra_id'))->first();

        if(!$compra)
        {
            return $this->crearRespuestaError('Id de compra no existe', 404);
        }

        $datos = CompraEstado::where('id', $id)->update([
            'estado' => $request->input('estado')
        ]);

        if ($datos){
            return $this->crearRespuesta('Estsdo ' . $id . ' actualizado', $categoria, 200);
        }else{
            return $this->crearRespuestaError('Estado no existe', 404);
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

        $compra_estado = CompraEstado::where($query)->get();
        
        if(!$compra_estado)
        {
            return $this->crearRespuestaError('Estados no encontrados', 404);
        }
        return $this->crearRespuesta('Estados encontrados', $compra_estado, 200);     

    }


    public function validacion($request)
    {   

        $reglas = 
        [
            'compra_id' => 'required',
            'estado' => 'required',
        ];

        $this->validate($request, $reglas);
    }


}
