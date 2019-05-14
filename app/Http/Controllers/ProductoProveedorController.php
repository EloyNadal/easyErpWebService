<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ProductoProveedor;
use App\Producto;
use App\ProductoProductoProveedor;

class ProductoProductoProveedorController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $producto_proveedor = ProductoProveedor::create($request->all());

        return $this->crearRespuesta('Relacion creada', $producto_proveedor, 201);
    }

    public function delete($id){

        $producto_proveedor = ProductoProveedor::where('id', $id)->first();

        if($producto_proveedor){
            $producto_proveedor->delete();
            return $this->crearRespuesta("Relacion $id eliminada", $producto_proveedor, 200);
        }
        else{
            return $this->crearRespuestaError("Relacion $id no existe", 404);
        }

    }

    public function read($id){
        
        $producto_proveedor = ProductoProveedor::where('id', $id)->first();

        if(!$producto_proveedor)
        {
            return $this->crearRespuestaError('Relacion no existe', 404);
        }
        return $this->crearRespuesta('Relacion encontrada', $producto_proveedor, 200);     

    }

    public function readAll(){

        $producto_proveedors = ProductoProveedor::all();
        return $this->crearRespuesta('Relaciones encontradas', $producto_proveedors, 200);

    }

    public function readQuery(Request $request, $metodo){

        $query = array();
        $condicion = ($metodo == 0) ? "and" : "or";

        foreach ($request->input() as $key => $value) {

                if (is_numeric($value)){
                    $queryvalue = [$key, '=', $value, $condicion];    
                }
                else{
                    $queryvalue = [$key, 'LIKE', "%$value%", $condicion];       
                }
                
                array_push($query, $queryvalue);
        }   

        $producto_proveedor = ProductoProveedor::where($query)->get();
        
        if(!$producto_proveedor)
        {
            return $this->crearRespuestaError('Relaciones no encontradas', 404);
        }
        return $this->crearRespuesta('Relaciones encontradas', $producto_proveedor, 200);     

    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $producto_proveedor = ProductoProveedor::where('id', $id)->first();

        if (!$producto_proveedor){
            return $this->crearRespuestaError("ProductoProveedor $id no existe", 404);
        }

        $producto_id = Producto::where('id', $request->input('producto_id'));
        $proveedor_id = Proveedor::where('id', $request->input('proveedor_id'));

        if (!$proveedor_id){
            return $this->crearRespuestaError("Proveedor $proveedor_id no existe", 404);
        }        

        if (!$producto_id){
            return $this->crearRespuestaError("Proveedor $producto_id no existe", 404);
        }

        $producto_proveedor->producto_id = $producto_id;
        $producto_proveedor->proveedor_id = $proveedor_id;

        $producto_proveedor->save();

        return $this->crearRespuesta("Relacion $id actualizado", $producto_proveedor, 200);        
    }

    public function validacion($request)
    {   
        $reglas = 
        [
            'producto_id' => 'required',
            'proveedor_id' => 'required',
        ];

        $this->validate($request, $reglas);
    }


}
