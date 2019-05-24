<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Producto;
use App\Tasa;
use App\Categoria;
use App\Stock;
use App\ProductoProveedor;
use App\Proveedor;


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

        if ($request->input('proveedor_id')){

            $relacion = ProductoProveedor::updateOrInsert(
                    ['producto_id' => $producto['id']],
                    ['proveedor_id' => $request->input('proveedor_id')]
            )->first();

            if($relacion){
                $proveedor = Proveedor::where('id', $relacion['proveedor_id'])->first();
                $producto->proveedor = $proveedor;
            }
        }

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

    public function read($id){

        $producto = Producto::where('id', $id)->first();
        //$producto['imagen'] = $_SERVER['HTTP_HOST'] . $producto['imagen'];
        
        if(!$producto)
        {
            return $this->crearRespuestaError('Producto no existe', 404);
        }

        $producto->imagen = $this->server() . $producto['imagen'];
        $tasa = Tasa::where('id', $producto['tasa_id'])->first();
        $categoria = Categoria::where('id', $producto['categoria_id'])->first();
        $stocks = Stock::where('producto_id', $producto['id'])->get();

        if($stocks){
            $producto->stocks = $stocks;    
        }
        
        $relacion = ProductoProveedor::where('producto_id', $producto['id'])->first();

        if($relacion){
            $proveedor = Proveedor::where('id', $relacion['proveedor_id'])->first();
            $producto->proveedor = $proveedor;
        }

        
        $producto->categoria = $categoria;
        $producto->tasa = $tasa;

        return $this->crearRespuesta('Producto encontrado', $producto, 200);     

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

        $productos = Producto::where($query)->get();
        
        if(!$productos)
        {
            return $this->crearRespuestaError('Productos no encontrados', 404);
        }

        foreach ($productos as $producto) {

            $producto->imagen = $this->server() . $producto['imagen'];

            $tasa = Tasa::where('id', $producto['tasa_id'])->first();
            $categoria = Categoria::where('id', $producto['categoria_id'])->first();
            $stocks = Stock::where('producto_id', $producto['id'])->get();

            $relacion = ProductoProveedor::where('producto_id', $producto['id'])->first();



            if($relacion){
                $proveedor = Proveedor::where('id', $relacion['proveedor_id'])->first();
                $producto->proveedor = $proveedor;
            }
            

            if($stocks){
                $producto->stocks = $stocks;    
            }

            $producto->categoria = $categoria;
            $producto->tasa = $tasa;
        }

        return $this->crearRespuesta('Producto encontrado', $productos, 200);     
    }

    public function readAll(){

        $productos = Producto::all();

        if(sizeof($productos)>0){

            foreach ($productos as $producto) {

                $tasa = Tasa::where('id', $producto['tasa_id'])->first();
                $categoria = Categoria::where('id', $producto['categoria_id'])->first();
                $stocks = Stock::where('producto_id', $producto['id'])->get();

                if($stocks){
                   $producto->stocks = $stocks;    
                }
                $relacion = ProductoProveedor::where('producto_id', $producto['id'])->first();

                if($relacion){
                    $proveedor = Proveedor::where('id', $relacion['proveedor_id'])->first();
                    $producto->proveedor = $proveedor;
                }   

                $producto->imagen = $this->server() . $producto['imagen'];
                $producto->categoria = $categoria;
                $producto->tasa = $tasa;
                $producto->stocks = $stocks;
                
            }
            return $this->crearRespuesta('Productos encontrados', $productos, 200);
        }

        return $this->crearRespuestaError('Productos no encontrados', 404);
    }

    public function update(Request $request, $id){

        $this->validacion($request);
        
        $producto = Producto::where('id', $id)->first();

        if (!$producto)
        {
            return $this->crearRespuestaError("Producto $id no existe", 404);   
        }

        foreach ($request->input() as $key => $value) {
            if ($key != 'proveedor_id'){
                $producto[$key] = $value;
            }else{
                
                $relacion = ProductoProveedor::updateOrInsert(
                    ['producto_id' => $producto['id']],
                    [$key => $value]
                )->first();
            }
        }


        $producto->save();
        $producto->imagen = $this->server() . $producto['imagen'];

        if($relacion){
            $proveedor = Proveedor::where('id', $relacion['proveedor_id'])->first();
            $producto->proveedor = $proveedor;
        }

        return $this->crearRespuesta("Producto $id actualizado", $producto, 200);        
    }

    public function saveImage(Request $request){
                
        $directorio_imagenes = (__DIR__ . '/../../../public/imagenes');

        //creo el directorio si este no existe
        if (!file_exists($directorio_imagenes)){
            mkdir($directorio_imagenes);
        }

        //['file'] indica el nombre dado al enviarlo
        $file = $_FILES['file'];
        $nombre = $_FILES['file']['name'];
        $path_archivo_temporal = $_FILES['file']['tmp_name'];
        $path_archivo_temporal_nuevo;
        $error = $_FILES['file']['error']; // >0 si error
        $tamaño = $_FILES['file']['size'];

        $nueva_ruta = realpath($directorio_imagenes) . '\\' . $nombre;

        //guardo el archivo temporal de manera fisica para poder extraer su MIME
        $resultado = move_uploaded_file($path_archivo_temporal, $nueva_ruta);


        //si no hay errores y mime correcto guardo la imagen en mi directorio
        if (!$resultado || $error > 0 ||
            (exif_imagetype($nueva_ruta) != IMAGETYPE_JPEG 
                &&  exif_imagetype($nueva_ruta) != IMAGETYPE_PNG))
        {

            //borra fichero
            unlink($nueva_ruta);
            return response()->json([
                'success' => false,
                'message' => 'error con formato imagen',
                'data' => 'fallo'
                ], 404);

        }
        else{   
            //establezco en la db, segun el server donde estoy, la ruta de la imagen

            $id = $request->input('id');
            $producto = Producto::where('id', $id)->first();

            $producto->imagen = $protocol . $rutaServer;
            $producto->save();

            return response()->json([
                'success' => true,
                'message' => 'imagen!',
                'data' => $nombre
            //image_type_to_mime_type(exif_imagetype($path_archivo_temporal))
            ], 202);

        }

    }

    public function validacion($request)
        {   
            $reglas = 
            [
                'categoria_id' => 'required',
                'referencia' => 'required',
                'nombre' => 'required',
                'precio' => 'required',
                'tasa_id' => 'required',
                'activo' => 'required'
            ];

            $this->validate($request, $reglas);
        }

}
