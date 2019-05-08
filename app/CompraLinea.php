<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


class CompraLinea extends Model
{
 	protected $table = 'compra_lineas';
 	public $timestamps = false;   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //falta añadir el producto en la tabla
    protected $fillable = ['tienda_id', 'compra_id', 'producto_id' , 'precio', 'tasa_id', 'cantidad', 'unidad_mesura'];

   //nombre de stok

}
