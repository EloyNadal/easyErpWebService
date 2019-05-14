<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{   
    
	public function crearRespuesta($mensaje, $datos, $codigo)
    {   

        
    	return response()->json([
            'succes' => true,
            'message' => $mensaje,
            'data' => $datos
            //'data' => $this->encrypt($datos, getenv('KEY'))
        ], $codigo);
    }

    public function crearRespuestaError($mensaje, $codigo)
    {
    	return response()->json([
            'succes' => false,
            'message' => $mensaje,
            'data' => ''
        ], $codigo);
    }


    public function desencrypt(Request $request){
        
        $data = $request->input("data");

        $result = openssl_decrypt(base64_decode($data), "aes-128-ecb", $key, OPENSSL_RAW_DATA);

        return $result;
    }

    public function encrypt($data, $key) {
        return base64_encode(openssl_encrypt($data, "aes-128-ecb", $key, OPENSSL_RAW_DATA));
    }


}
