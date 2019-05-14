<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Categoria;
use App\Producto;

class CategoriaController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['read', 'readAll']]);
        $this->middleware('admin', ['only' => ['create', 'delete', 'update']]);
    }

    public function create(Request $request){

        $this->validacion($request);

        $nombre = $request->input('nombre');
        $categoria_id = $request->input('categoria_id');

        $categoria_padre = Categoria::where('id', $categoria_id)->first();

        if(!$categoria_padre){
            return $this->crearRespuestaError('Categoria padre no existe', 404);
        }
        
        $datos = Categoria::create([
            'nombre' => $nombre,
            'categoria_id' => $categoria_id,
        ]);

        return $this->crearRespuesta('Categoria creada', $datos, 200);
    }

    public function delete($id){

        $categoria = Categoria::where('id', $id)->first();

        if($categoria){

            $productos = Producto::where('categoria_id', $id)->get();
            if (sizeof($productos) > 0){
                return $this->crearRespuestaError("La categoria contiene productos que se deben borrar antes", 404);    
            }

            $categoria->delete();
            return $this->crearRespuesta('Categoria eliminada', $categoria, 200);
        }
        else{
            return $this->crearRespuestaError('Categoria no existe', 404);
        }

    }

    public function read($id){
        
        $categoria = Categoria::where('id', $id)->first();



        if($categoria){
            return $this->crearRespuesta('Categoria encontrada', $categoria, 200);
        }
        else{
            return $this->crearRespuestaError('Categoria no existe', 404);
        }        

    }

    public function readAll(){

        $categorias = Categoria::all();
        return $this->crearRespuesta('Categorias encontradas', $categorias, 200);

    }

    public function update(Request $request, $id){

        $nombre = $request->input('nombre');
        $categoria_id = $request->input('categoria_id');        

        $this->validacion($request);

        $categoria_padre = Categoria::where('id', $categoria_id)->first();

        if(!$categoria_padre){
            return $this->crearRespuestaError('Categoria_id no existe', 404);
        }
        
        $datos = Categoria::where('id', $id)->update([
            'nombre' => $nombre,
            'categoria_id' => $categoria_id,
        ]);

        if ($datos){
            $categoria = Categoria::where('id', $id)->first();
            return $this->crearRespuesta('Categoria ' . $id . ' actualizada', $categoria, 200);
        }else{
            return $this->crearRespuestaError('Categoria no existe', 404);   
        }
        
    }

    public function validacion($request)
    {   

        $reglas = 
        [
            'nombre' => 'required',
            'categoria_id' => 'required',
        ];

        $this->validate($request, $reglas);
    }


}
