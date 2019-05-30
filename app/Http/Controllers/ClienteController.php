<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cliente;
use App\GrupoCliente;

class ClienteController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll', 'readQuery']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);

    }

    public function create(Request $request){

        $this->validacion($request, 'create');

        if(!GrupoCliente::where('id', $request->input('grupo_cliente_id'))->first()){
            return $this->crearRespuestaError('Grupo clientes no existe', 404);
        }

        $datos = Cliente::create($request->all());
        $codigo = "0000000000000";
        $datos->codigo = substr($codigo, 0, -strlen($datos['id'])) . $datos['id'];
        $datos->save();
        
        return $this->crearRespuesta('Cliente creado', $datos, 200);
    }

    public function delete($id){

        $cliente = Cliente::where('id', $id)->first();

        if($cliente){
            $cliente->delete();
            return $this->crearRespuesta('Cliente eliminado', $cliente, 200);
        }
        else{
            return $this->crearRespuestaError('Cliente no existe', 404);
        }

    }

    public function read($id){
        
        $cliente = Cliente::where('id', $id)->first();


        if($cliente){

            $grupo_cliente = GrupoCliente::where('id', $cliente['grupo_cliente_id'])->first();
            $cliente->grupo_cliente = $grupo_cliente;

            return $this->crearRespuesta('Cliente encontrado', $cliente, 200);
        }
        else{
            return $this->crearRespuestaError('Cliente no existe', 404);
        }

    }

    public function readAll(){

        $clientes = Cliente::all();

        if (sizeof($clientes)>0){

            foreach ($clientes as $cliente) {
                $grupo_cliente = GrupoCliente::where('id', $cliente['grupo_cliente_id'])->first();
                $cliente->grupo_cliente = $grupo_cliente;
            }

            return $this->crearRespuesta('Clientes encontradas', $clientes, 200);

        }
        return $this->crearRespuestaError('No existen clientes', 404);
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

        $clientes = Cliente::where($query)->get();
        
        if(!$clientes)
        {
            return $this->crearRespuestaError('Productos no encontrados', 404);
        }
        foreach ($clientes as $cliente) {
                $grupo_cliente = GrupoCliente::where('id', $cliente['grupo_cliente_id'])->first();
                $cliente->grupo_cliente = $grupo_cliente;
            }        
        return $this->crearRespuesta('Producto encontrado', $clientes, 200);     

    }

    public function update($id, Request $request){

        $this->validacion($request, 'update');

        $grupo_cliente_id = $request->input('grupo_cliente_id');
        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellidos');
        $direccion = $request->input('direccion');
        $ciudad = $request->input('ciudad');
        $telefono = $request->input('telefono');
        $codigo_postal = $request->input('codigo_postal');
        $pais = $request->input('pais');
        $email = $request->input('email');
        $dni = $request->input('dni');

        $grupo = GrupoCliente::where('id', $grupo_cliente_id)->first();

        if(!$grupo){
            return $this->crearRespuestaError('Grupo clientes no existe', 404);
        }
        
        $cliente = Cliente::where('id', $id)->update([
            'grupo_cliente_id' => $grupo_cliente_id,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'direccion' => $direccion,
            'ciudad' => $ciudad,
            'telefono' => $telefono,
            'codigo_postal' => $codigo_postal,
            'pais' => $pais,
            'email' => $email,
            'dni' => $dni
        ]);

        if ($cliente){
            $datos = Cliente::where('id', $id)->first();
            return $this->crearRespuesta('Cliente ' . $id . ' actualizado', $datos, 200);
        }else{
            return $this->crearRespuestaError('Cliente ' . $id . 'no existe', 404);
        }
    }

    public function generarCodigo($longitud){
        $cod = "";
        for ($i=0; $i < $longitud; $i++) { 
            $cod .= rand(0,9);
        }
        return $cod;
    }

    public function validacion($request, $metodo)
    {   

        $reglas = null;
        if ($metodo == 'create')
        {
            $reglas = 
                [   
                'grupo_cliente_id' => 'required',
                'nombre' => 'required',
                'apellidos' => 'required',
                'email' => 'required|unique:clientes,email',
                'dni' => 'required|unique:clientes,dni',
            ];

        }elseif($metodo == 'update')
        {
            $reglas = 
            [   
                'grupo_cliente_id' => 'required',
                'nombre' => 'required',
                'apellidos' => 'required',
                'email' => 'required',
                'dni' => 'required',
            ];
        }

        $this->validate($request, $reglas);
    }

}
