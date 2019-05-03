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

        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellidos');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $admin = $request->input('admin');
        $tienda_id = $request->input('tienda_id');

        $registrar = Usuario::create([
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $email,
            'password' => $password,
            'admin' => $admin,
            'tienda_id' => $tienda_id
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

        $email = $request->input('email');
        $password = $request->input('password');

        $usuario = Usuario::where('email', $email)->first();
        $validacion = false;

        //usuario admin por defecto valida de forma distinta a los usuarios creados a posteriori

        if ($usuario['nombre'] == 'admin'){
            $validacion = Usuario::where('email', $email)->where('password', $password)->first();
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
                'data' => [
                    'user' => $usuario,
                    'api_token' => $apiToken
                ]
            ], 201);
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
            'nombre' => 'required',
            'apellidos' => 'required',
            //campo unique => (param1 = tabla, param2 => columna)
            'email' => 'required|unique:usuarios,email',
            'password' => 'required',
            'admin' => 'required',
            'tienda_id' => 'required'
        ];

        $this->validate($request, $reglas);
    }


}
