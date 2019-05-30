<?php

namespace App\Http\Middleware;

use App\Usuario;
use App\GrupoUsuario;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {   


        /*
        *Metodo para pruebas en postman
        */
        //$apiToken = $request->header('Authorization');
            
        /*
        *Metodo para eclipse
        */
        $apiToken = openssl_decrypt(base64_decode($request->header('Authorization')),"aes-128-ecb",getenv('KEY'),OPENSSL_RAW_DATA);

        $usuario = Usuario::where('api_token', $apiToken)->first();
        $permiso = GrupoUsuario::where('id', $usuario['grupo_usuario_id'])->first();

        if (!$usuario || $permiso['permiso'] != 'R' || $permiso['permiso'] != 'W')
        {
            return response('Unauthorized.', 401);                
        }
        else
        {
            return $next($request);
        }


        /**
        *metodo original
        
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }
        **/
        return $next($request);
    }

    public function crearRespuesta($mensaje, $datos, $codigo)
    {   

        return response()->json([
            'succes' => true,
            'message' => $mensaje,
            'data' => $datos
            //'data' => $this->encrypt($datos, getenv('KEY'))
        ], $codigo);
    }


}
