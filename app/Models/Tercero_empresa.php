<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Tercero_empresa extends Model {

	protected $primaryKey = "id";
	protected $table = "empresa_tercero";


   protected $fillable = [
        'tercero_id','empresa_id','tipo','num_key','deleted'
    ];
   public $timestamps = false;

    // protected $hidden = [
    //     'password',
    // ];
}
