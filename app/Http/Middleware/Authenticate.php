<?php

namespace App\Http\Middleware;

use App\Usuario;
use App\GrupoUsuario;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate extends DesencryptKey
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


        /**
         *@param boolean a False, en caso de enviar contraseña sin encriptar
         */
        $apiToken = $this->desencrypt($request->header('Authorization'),True);

        if (!$apiToken) return response('Unauthorized.', 401);

        $usuario = Usuario::where('api_token', $apiToken)->first();

        if (!$usuario)
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
}
