<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Empleado;

class EmpleadoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll', 'readQuery']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }
    
    public function create(Request $request){

        $this->validacion($request);

        $empleado = Empleado::create($request->all());
        return $this->crearRespuesta('Empleado creado', $empleado, 201);
    }

    public function delete($id){

        $empleado = Empleado::where('id', $id)->first();

        if($empleado){
            $empleado->delete();
            return $this->crearRespuesta("Empleado $id eliminado", $empleado, 200);
        }
        else{
            return $this->crearRespuestaError("Empleado $id no existe", 404);
        }

    }

    public function read($id){
        
        $empleado = Empleado::where('id', $id)->first();
        if(!$empleado)
        {
            return $this->crearRespuestaError('Empleado no existe', 404);
        }
        return $this->crearRespuesta('Empleado encontrado', $empleado, 200);     

    }

    public function readAll(){

        $empleados = Empleado::all();
        return $this->crearRespuesta('Empleado encontrados', $empleados, 200);

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

        $empleado = Empleado::where($query)->get();
        
        if(!$empleado)
        {
            return $this->crearRespuestaError('Productos no encontrados', 404);
        }
        return $this->crearRespuesta('Producto encontrado', $empleado, 200);     

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $empleado = Empleado::where('id', $id)->first();

        if (!$empleado)
        {
            return $this->crearRespuestaError("Empleado $id no existe", 404);   
        }
    
        $empleado->nombre = $request->input('nombre');
        $empleado->apellidos = $request->input('apellidos');
        $empleado->direccion = $request->input('direccion');
        $empleado->ciudad = $request->input('ciudad');
        $empleado->telefono = $request->input('telefono');
        $empleado->codigo_postal = $request->input('codigo_postal');
        $empleado->pais = $request->input('pais');
        $empleado->email = $request->input('email');
        $empleado->dni = $request->input('dni');
        $empleado->tienda_id = $request->input('tienda_id');

        $empleado->save();

        return $this->crearRespuesta("Empleado $id actualizado", $empleado, 200);        
    }

    public function validacion($request)
    {   
        
        $reglas = 
        [
            'nombre' => 'required',
            'email' => 'required',
            'dni' => 'required',
            'tienda_id' => 'required'
        ];

        $this->validate($request, $reglas);
    }


}
