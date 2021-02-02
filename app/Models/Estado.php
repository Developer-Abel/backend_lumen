<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Estado extends Model {

	protected $primaryKey = "id_estado";
	public $timestamps = false;
	protected $table = 'estados';

   protected $fillable = ['estado','pais_id'];

    protected $hidden = [
        'password',
    ];
}
