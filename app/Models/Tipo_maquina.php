<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Tipo_maquina extends Model {

	protected $primaryKey = "id_tipo_maquina";
	public $timestamps = false;
	protected $table = 'tipo_maquinas';

   protected $fillable = [
        'nombre','precio_millar'
    ];


}
