<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $producto = Producto::create($request->all());

        return $this->crearRespuesta('Producto creado', $producto, 201);
    }

    public function delete($id){

        $producto = Producto::where('id', $id)->first();

        if($producto){
            $producto->delete();
            return $this->crearRespuesta("Producto $id eliminado", $producto, 200);
        }
        else{
            return $this->crearRespuestaError("Producto $id no existe", 404);
        }

    }

    public function readId($id){

        return $this->crearRespuesta('Producto encontrado', $id, 200);
        $referencia = $request->input('referencia');
        if ($referencia)
        {
            $producto = Producto::where('referencia', $referencia)->first();
        }
        else{
            $producto = Producto::where('id', $id)->first();    
        }
        

        if(!$producto)
        {
            return $this->crearRespuestaError('Producto no existe', 404);
        }
        return $this->crearRespuesta('Producto encontrado', $producto, 200);     

    }

    public function read($campo, $valor){


        if ($campo == 'id' || $campo == 'referencia' || $campo == 'categoria_id')
        {
            $producto = Producto::where($campo, $valor)
                                ->get();
        }
        else
        {
            return $this->crearRespuestaError("opcion no valida, formato correcto: 'campo = valor'", 404);
        }
        
        if(!$producto)
        {
            return $this->crearRespuestaError('Producto no existe', 404);
        }
        return $this->crearRespuesta('Producto encontrado', $producto, 200);     

    }

    public function readQuery(Request $request, $metodo){

        $valores = array();
        $ky = array_keys($request->input());
        $val = array_values($request->input());

        $productos = Producto::where($request->input())
                                    ->get();        

        return $this->crearRespuesta('Producto encontrado', $productos, 200);     

        if ($metodo == 'and'){


        }else
        
        {
            foreach ($request->input() as $key => $value) {
                
                switch ($key) {


                    case 'categoria_id':
                    case 'tasa_id':


                        $productos = Producto::where($key, "=" , $value)
                                    ->get();
                        break;

                    default: 
                        $productos = Producto::where($key, "LIKE" , "%$value%");
                        break;
                }
            
                array_push($valores, $productos);
            }

        }

        
        return $this->crearRespuesta('Producto encontrado', $valores, 200);

        $producto = Producto::where($campo, $valor)->get();
        
        if(!$producto)
        {
            return $this->crearRespuestaError('Producto no existe', 404);
        }
        return $this->crearRespuesta('Producto encontrado', $producto, 200);     

    }

    public function readParam($param){

        return $this->crearRespuesta('Producto encontrado', $param, 200);

        $valores = array();
        foreach ($request->input() as $key => $value) {
            
            $productos = Producto::where($key, "LIKE" , "%$value%")
            ->get();

            array_push($valores, $productos);
        }
        

        $producto = Producto::where($campo, $valor)->get();
        
        if(!$producto)
        {
            return $this->crearRespuestaError('Producto no existe', 404);
        }
        return $this->crearRespuesta('Producto encontrado', $producto, 200);

    }

    public function readAll(){

        $productos = Producto::all();
        return $this->crearRespuesta('Productos encontrados', $productos, 200);

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $producto = Producto::where('id', $id)->first();

        if (!$producto)
        {
            return $this->crearRespuestaError("Producto $id no existe", 404);   
        }
        
        $producto->nombre = $request->input('nombre');
        $producto->direccion = $request->input('direccion');
        $producto->ciudad = $request->input('ciudad');
        $producto->telefono = $request->input('telefono');
        $producto->email = $request->input('email');
        $producto->codigo_postal = $request->input('codigo_postal');
        $producto->pais = $request->input('pais');

        $producto->save();

        return $this->crearRespuesta("Producto $id actualizado", $producto, 200);        
    }

    public function validacion($request)
    {   

        $reglas = 
        [
            'categoria_id' => 'required',
            'ean13' => 'required',
            'referencia' => 'required',
            'atributo' => 'required',
            'atributo_valor' => 'required',
            'nombre' => 'required',
            'unidad_mesura' => 'required',
            'precio' => 'required',
            'tasa_id' => 'required',
            'stock_minimo' => 'required',
            'activo' => 'required'
        ];

        $this->validate($request, $reglas);
    }


}
