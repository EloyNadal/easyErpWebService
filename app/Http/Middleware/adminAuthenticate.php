<?php

namespace App\Http\Middleware;

use Closure;
use App\Usuario;

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

            $apiToken = $request->header('Authorization');

            $usuario = where('api_token', $apiToken)->first();

            if (!$usuario || $usuario['grupo_usuario_id'] != 1)
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
