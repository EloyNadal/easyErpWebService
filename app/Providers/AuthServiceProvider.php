<?php

namespace App\Providers;

use App\Usuario;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('Authorization')) {

                //$apiToken = explode(' ', $request->header('Authorization'));
                $apiToken = $request->header('Authorization');

                //la posicion [0] del apitoken ahora mismo puede ser cualquier valor, pero podria mirar de añadir una barrera mas para segun que permisos necesite

                //ahora el valor admin debe coincidir con el usuario (1)admin (0)user
                return Usuario::where('api_token', $apiToken)->first();
            }
        });
    }
}
