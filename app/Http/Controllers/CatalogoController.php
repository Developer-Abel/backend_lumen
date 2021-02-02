<?php

namespace App\Http\Controllers;
use App\models\Acabado;
use App\models\Tipo_papel;
use App\models\Tipo_maquina;
use App\models\Pais;
use App\models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;


class CatalogoController extends Controller
{
    public function __construct(){
    }

    function acabado(){
      $acabado = Acabado::all();
       return response()->json($acabado,200);
    }
    function tipo_papel(){
      $tipo_papel = Tipo_papel::all();
       return response()->json($tipo_papel,200);
    }
    function tipo_maquina(){
      $tipo_maquina = Tipo_maquina::all();
       return response()->json($tipo_maquina,200);
    }
    function pais(){
      $pais = pais::all();
      return response()->json($pais,200);
    }
    function estado(){
      $estado = Estado::all();
      return response()->json($estado,200);
    }
}





