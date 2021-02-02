<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Tercero extends Model {

	protected $primaryKey = "id_tercero";


   protected $fillable = [
        'nombre','telefono','celular','email','calle','num_int','num_ext','direccion','barrio','estado_id','pais_id','deleted'
    ];
   public $timestamps = false;
    // protected $hidden = [
    //     'password',
    // ];
}
