<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Cliente extends Model
{
    protected $table = 'clientes';
    //public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['grupo_cliente_id', 'nombre', 'apellidos', 'direccion', 'ciudad', 'telefono', 'codigo_postal', 'pais', 'email', 'dni'];
    
}
