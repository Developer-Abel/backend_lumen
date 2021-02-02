<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Acabado extends Model {

	protected $primaryKey = "id_acabado";
	public $timestamps = false;

   protected $fillable = [
        'descripcion','unidad_medida','precio'
    ];

    protected $hidden = [
        'password',
    ];
}
