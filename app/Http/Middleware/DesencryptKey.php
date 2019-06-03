<?php

namespace App\Http\Middleware;

use Closure;
use App\Usuario;
use App\GrupoUsuario;

class DesencryptKey
{

    /**
     * Desencriptar o no la clave enviada en el request, recibir falso solo en caso de pruebas
     *
     * @param  clave  $auth
     * @param  si desencriptar  $method
     * @return token desencriptado o no.
     */
    public function desencrypt(string $auth, bool $method)
    {

        /*
        *Metodo para eclipse
        */
        if ((bool)$method)
        {
            return openssl_decrypt(base64_decode($auth),"aes-128-ecb",getenv('KEY'),OPENSSL_RAW_DATA);
        }
        /*
        *Metodo para pruebas en postman
        */
        else
        {
            return $auth;
        }
            
    }
}
