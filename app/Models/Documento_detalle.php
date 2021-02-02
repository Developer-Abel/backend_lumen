<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Documento_detalle extends Model {

	protected $primaryKey = "id_detalle";
	 protected $table = 'documento_detalle';
	 public $timestamps = false;

   protected $fillable = [
        'empresa_id','documento_id','tipo_documento','observaciones','cantidad','descripcion','	val_unitario','val_total','deleted'
    ];

    protected $hidden = [
        'password',
    ];
}
