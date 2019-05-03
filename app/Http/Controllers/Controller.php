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


}
