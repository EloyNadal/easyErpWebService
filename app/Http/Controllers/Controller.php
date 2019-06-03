<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{   

    
	public function crearRespuesta($mensaje, $datos, $codigo)
    {   
    	return response()->json([
            'succes' => true,
            'message' => $mensaje,
            /**
             *postman
             */
            //'data' => $datos
            'data' => $this->encrypt($datos, getenv('KEY'))
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

        $data = $request->input()[0];
        $result = openssl_decrypt(base64_decode($data), "aes-128-ecb", getenv('KEY'), OPENSSL_RAW_DATA);

        $result = $this->converToUtf8_recursiva($result);
        $result = json_decode($result, true);

        //voy por aqui! este ya funciona
        //$a = $result['proveedor'];

        return $result;
    }

    public function encrypt($data, $key) {
        return base64_encode(openssl_encrypt($data, "aes-128-ecb", $key, OPENSSL_RAW_DATA));
    }

    public function server(){
        return "http://" . $_SERVER['HTTP_HOST'] . "/imagenes/";
    }

    public static function converToUtf8_recursiva($dat)
   {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }


}
