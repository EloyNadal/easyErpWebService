<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


class Producto extends Model
{
    protected $table = 'productos';
    //public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categoria_id', 'ean13', 'referencia', 'atributo', 'atributo_valor', 'nombre', 'unidad_mesura', 'precio', 'tasa_id', 'stock_minimo', 'activo', 'fabricante', 'imagen'
    ];

/*
    public function tasa()
    {
        return $this->belongsTo('App\Tasa');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }
*/

}
