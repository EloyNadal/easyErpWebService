<?php

namespace App\Http\Middleware;

use Closure;
use App\Usuario;
use App\GrupoUsuario;

class adminAuthenticate extends DesencryptKey
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

            /**
             *@param boolean a False, en caso de enviar contraseña sin encriptar
             */
            $apiToken = $this->desencrypt($request->header('Authorization'), True);
            if (!$apiToken) return response('Unauthorized.', 401);

            $usuario = Usuario::where('api_token', $apiToken)->first();
            $permiso = GrupoUsuario::where('id', $usuario['grupo_usuario_id'])
                ->where('permiso', 'W')->first();

            if (!$usuario || !$permiso)
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
