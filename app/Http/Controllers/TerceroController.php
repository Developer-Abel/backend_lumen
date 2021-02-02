<?php

namespace App\Http\Controllers;
use App\models\Empresa;
use App\models\Tercero_empresa;
use App\models\Tercero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TerceroController extends Controller
{
    public function __construct(){
    }
    function index_cli(){
      $user=Auth()->user();
      $cliente = Tercero::select(
        'terceros.id_tercero',
        'terceros.nombre',
        'terceros.telefono',
        'terceros.celular',
        'terceros.email',
        'terceros.calle',
        'terceros.num_int',
        'terceros.num_ext',
        'terceros.barrio',
        'terceros.direccion',
        'estados.estado',
        'paises.pais',
        'empresa_tercero.num_key'

      )
          ->join('empresa_tercero', 'empresa_tercero.tercero_id', '=', 'terceros.id_tercero')
          ->leftjoin('estados', 'estados.id_estado', '=', 'terceros.estado_id')
          ->leftjoin('paises', 'paises.id_pais', '=', 'estados.pais_id')
          ->where('empresa_tercero.empresa_id',$user->empresa_id)
          ->where('empresa_tercero.tipo','cliente')
          ->where('empresa_tercero.deleted',0)
          ->where('terceros.deleted',0)
          ->orderBy('terceros.id_tercero', 'desc')
          ->get();
       return response()->json( $cliente,200);
    }
    function getCliente(Request $request){
      $user=Auth()->user();
      $cliente = Tercero::select(
        'terceros.id_tercero',
        'terceros.nombre',
        'terceros.telefono',
        'terceros.celular',
        'terceros.email',
        'terceros.calle',
        'terceros.num_int',
        'terceros.num_ext',
        'terceros.barrio',
        'terceros.direccion',
        'estados.estado',
        'paises.pais',
        'empresa_tercero.num_key'
      )
          ->join('empresa_tercero', 'empresa_tercero.tercero_id', '=', 'terceros.id_tercero')
          ->leftjoin('estados', 'estados.id_estado', '=', 'terceros.estado_id')
          ->leftjoin('paises', 'paises.id_pais', '=', 'estados.pais_id')
          ->where('empresa_tercero.empresa_id',$user->empresa_id)
          ->where('empresa_tercero.tipo','cliente')
          ->where('empresa_tercero.num_key',$request->num_key)
          ->where('empresa_tercero.deleted',0)
          ->where('terceros.deleted',0)
          ->first();

          if ($cliente == null) {
            return response()->json( "Cliente no encontrado",401);
          }
       return response()->json( $cliente,200);
    }

    function saveCliente(Request $request){
      DB::beginTransaction();
      try{
         $user=Auth()->user();
         $cliente = new Tercero; //$user->empresa_id
         $cliente->nombre    = $request->nombre;
         $cliente->telefono  = $request->telefono;
         $cliente->celular   = $request->celular;
         $cliente->email     = $request->email;
         $cliente->direccion = $request->direccion;
         $cliente->barrio    = $request->barrio;
         $cliente->estado_id = $request->ciudad;
         $cliente->pais_id   = $request->pais;
         $cliente->save();
            $empresa = new Tercero_empresa;
            $empresa->tercero_id = $cliente->id_tercero;
            $empresa->empresa_id = $user->empresa_id;
            $empresa->tipo = $request->tipo_tercero;
            $empresa->num_key = $request->numero;
            $empresa->save();
         DB::commit();
         return response()->json($empresa->id ,200);
      }catch (\Exception $e){
         DB::rollback();
         return response()->json($e,400);
      }
   }

   function editarCliente(Request $request){
      $user=Auth()->user();
      $cliente = Tercero::select(
        'terceros.id_tercero',
        'terceros.nombre',
        'terceros.telefono',
        'terceros.celular',
        'terceros.email',
        'terceros.barrio',
        'terceros.direccion',
        'estados.id_estado',
        'paises.id_pais',
        'empresa_tercero.num_key'
      )
          ->join('empresa_tercero', 'empresa_tercero.tercero_id', '=', 'terceros.id_tercero')
          ->leftjoin('estados', 'estados.id_estado', '=', 'terceros.estado_id')
          ->leftjoin('paises', 'paises.id_pais', '=', 'estados.pais_id')
          ->where('empresa_tercero.empresa_id',$user->empresa_id)
          ->where('empresa_tercero.tipo','cliente')
          // ->where('empresa_tercero.num_key',$request->num_key)
          ->where('terceros.id_tercero',$request->id_tercero)
          ->first();

          if ($cliente == null) {
            return response()->json( "Cliente no encontrado",401);
          }
       return response()->json( $cliente,200);
   }
   function actualizarCliente(Request $request){
      $id_tercero = $request->idcliente;
      $empresa_tercero = Tercero_empresa::where('tercero_id', $id_tercero)
      ->update([
         'num_key' => $request->numero,
      ]);
      $tercero = Tercero::where('id_tercero', $id_tercero)
      ->update([
         'nombre'    => $request->nombre,
         'telefono'  => $request->telefono,
         'celular'   => $request->celular,
         'email'     => $request->email,
         'direccion' => $request->direccion,
         'barrio'    => $request->barrio,
         'estado_id' => $request->ciudad,
         'pais_id'  => $request->pais,
      ]);
      return response()->json($id_tercero ,200);
   }

   function eliminarCliente(Request $request){
    $id_tercero = $request->id_tercero;
      $empresa_tercero = Tercero_empresa::where('tercero_id', $id_tercero)
      ->update([
         'deleted' => 1,
      ]);
      $tercero = Tercero::where('id_tercero', $id_tercero)
      ->update([
         'deleted' => 1,
      ]);
      return response()->json($id_tercero ,200);
   }



}
