<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Documento extends Model {

	protected $primaryKey = "id_documento";
	public $timestamps = false;

   protected $fillable = [
        'empre_id','tercero_id','tipo_documento','no_documento','fecha','subtotal','descuento','iva',
        'total','observacion','deleted'
    ];

    protected $hidden = [
        'password',
    ];
}
