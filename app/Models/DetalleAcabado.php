<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class DetalleAcabado extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    protected $primaryKey = "Iddetalle_acabado";
    protected $fillable = [
        'detalle_id', 'acabado_id'
    ];
    protected $table = 'detalle_acabado';
    public $timestamps = false;


    // protected $hidden = [
    //     'password',
    // ];
}
