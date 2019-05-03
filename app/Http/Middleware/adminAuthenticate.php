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

            $apiToken = explode(' ', $request->header('Authorization'));

            $usuario = Usuario::where('admin', $apiToken[0])->where('api_token', $apiToken[1])->first();

            if (!$usuario || $usuario['admin'] != 1)
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
