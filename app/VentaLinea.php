<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


class VentaLinea extends Model
{
    protected $table = 'venta_lineas';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['tienda_id', 'venta_id', 'producto_id' , 'precio', 'tasa_id', 'cantidad', 'unidad_mesura'];


}
