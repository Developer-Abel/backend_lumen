<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class ItemSencillo extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    protected $primaryKey = "idItem";

    protected $fillable = ['detalle_id','tamano_v','cant_montaje','corte_papel_h','corte_papel_y','num_tinta_tiro','num_tinta_retiro','vr_diseno','vr_trasporte','vr_rifle','inicio_num','TamanoH'
    ];
    protected $table = 'itemsencillos';
    public $timestamps = false;


    // protected $hidden = [
    //     'password',
    // ];
}
