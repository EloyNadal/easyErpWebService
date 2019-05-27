<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;
use App\GrupoUsuario;

class UsuarioController extends Controller
{
    
    public function __construct()
    {
         $this->middleware('admin', ['only' => ['create']]);
       
    }

 public function create(Request $request){

        $this->validacion($request, 'create');


        $password = Hash::make($request->input('password'));
        $empleado_id = $request->input('empleado_id');
        $user_name = $request->input('user_name');
        $grupo_usuario_id = $request->input('grupo_usuario_id');

        $registrar = Usuario::create([
            'password' => $password,
            'empleado_id' => $empleado_id,
            'user_name' => $user_name,
            'grupo_usuario_id' => $grupo_usuario_id
        ]);

        if($registrar){
            return response() ->json([
                'success' => true,
                'message' => 'Registrado correctamente',
                'data' => $registrar,
            ], 201);

        }else{
            return response() ->json([
                'success' => false,
                'message' => 'Fallo al registrar',
                'data' => 'Nada',
            ], 400);
        }
    }

     public function validacion($request, $metodo)
    {   

        $reglas = null;
        if ($metodo == 'create')
        {
            $reglas = 
                [   
                'grupo_usuario_id' => 'required',
                'password' => 'required',
                'user_name' => 'required|unique:usuarios,user_name',
                'empleado_id' => 'required|unique:usuarios,empleado_id'
            ];

        }elseif($metodo == 'update')
        {
            $reglas = 
            [   
                'grupo_usuario_id' => 'required',
                'password' => 'required',
                'user_name' => 'required|unique:usuarios,user_name',
                'empleado_id' => 'required|unique:usuarios,empleado_id'
            ];
        }

        $this->validate($request, $reglas);
    }

}