<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model {

	protected $primaryKey = "id_usuario";


   protected $fillable = [
        'nombre','apellido_p','apellido_m','usuario','email','empresa_id','cedula','cargo','telefono','celular'
    ];

    protected $hidden = [
        'password',
    ];
}
