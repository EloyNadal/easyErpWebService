<?php

namespace App\Http\Middleware;

use Closure;
use App\Usuario;
use App\GrupoUsuario;

class adminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   

        if (!$request->header('Authorization')) 
        {
            return response('Unauthorized.', 401);   

        }
        else
        {
            $apiToken = openssl_decrypt(base64_decode($request->header('Authorization')),"aes-128-ecb",getenv('KEY'),OPENSSL_RAW_DATA);

            $usuario = Usuario::where('api_token', $apiToken)->first();
            $permiso = GrupoUsuario::where('id', $usuario['grupo_usuario_id'])->first();

            if (!$usuario || $permiso['permiso'] != 'W')
            {
                return response('Unauthorized.', 401);                
            }
            else
            {
                return $next($request);
            }
        }
    }
}
