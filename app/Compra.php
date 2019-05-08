<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\CompraProducto;

class Compra extends Model
{
 	protected $table = 'compras';
 	//public $timestamps = false;   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tienda_id', 'proveedor_id', 'precio_sin_tasas', 'total_tasas', 'precio_total'];


    public function comprasProductos($id)
	{
		$compras = CompraProducto::where('compra_id', $id);
		return $compras;
	}

}
