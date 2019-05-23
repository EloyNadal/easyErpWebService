<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;

class UsuarioAdminController extends Controller
{

    public function __construct()
    {
        //$this->middleware(['auth', 'secondMidel']);
        $this->middleware('admin', ['only' => ['registrar']]);
    }
    
    public function registrar(Request $request){

        $this->validacion($request);

        $password = Hash::make($request->input('password'));
        $api_token = $request->input('api_token');
        $empleado_id = $request->input('empleado_id');
        $user_name = $request->input('user_name');
        $grupo_usuario_id = $request->input('grupo_usuario_id');

        $registrar = Usuario::create([
            'password' => $password,
            'api_token' => $apiToken,
            'empleado_id' => $empleado_id,
            'user_name' => $user_name,
            'grupo_usuario_id' => $grupo_usuario_id
        ]);

        if($registrar){
            return response() ->json([
                'success' => true,
                'message' => 'Registrado correctamente',
                'data' => $registrar


            ], 201);
        }else{
            return response() ->json([
                'success' => false,
                'message' => 'Fallo al registrar',
                'data' => ''
            ], 400);
        }

    }

    public function login(Request $request){

        $user_name = $request->input('user_name');
        $password = $request->input('password');

        $usuario = Usuario::where('user_name', $user_name)->first();
        $validacion = false;

        //usuario admin por defecto valida de forma distinta a los usuarios creados a posteriori

        if ($usuario['user_name'] == 'admin' || $usuario['user_name'] == 'carlos' || $usuario['user_name'] == 'eloy'){

            $validacion = Usuario::where('user_name', $user_name)->where('password', $password)->first();

        }else{
            //usuario = 1234
            $validacion = Hash::check($password, $usuario->password);

        }


        if ($validacion){

            $apiToken = base64_encode(str_random(40));

            $usuario->update([
                'api_token' => $apiToken
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login Succes!',
                'data' => $usuario
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login Fail!',
                'data' => ''
            ], 404);
        }
    }

    
    public function validacion($request)
    {   

        $reglas = 
        [
            'password' => 'required',
            'empleado_id' => 'required',
            'user_name' => 'required',
            'grupo_usuario_id' => 'required'
        ];

        $this->validate($request, $reglas);
    }


}
