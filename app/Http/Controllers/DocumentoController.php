<?php

namespace App\Http\Controllers;
use App\models\Empresa;
use App\models\Documento;
use App\models\Documento_detalle;
use App\models\ItemSencillo;
use App\models\DetalleAcabado;
// use App\models\Acabado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// prueba
use Illuminate\Support\Facades\DB;


class DocumentoController extends Controller
{
    public function __construct(){
    }
    function all(){
      // $user=Auth()->user();
      $documentos = Documento::select('documentos.id_documento','documentos.tercero_id','documentos.no_documento','documentos.fecha','documentos.subtotal','documentos.descuento','documentos.iva','documentos.total','documentos.observacion','documentos.status','t.nombre')
      ->join('terceros as t','t.id_tercero', '=', 'documentos.tercero_id')
      ->where('documentos.deleted',0)
      ->where('documentos.status','!=','INCOMPLETO')->get();
      return response()->json($documentos,200);
   }

   function index($id){
      $user=Auth()->user();
      $documentos = Documento::select(
         'documentos.no_documento',
         'documento_detalle.id_detalle',
         'documento_detalle.documento_id',
         'documento_detalle.cantidad',
         'documento_detalle.descripcion',
         'documento_detalle.val_unitario',
         'documento_detalle.val_total',
         'documento_detalle.costo',
         'empresa_tercero.num_key',
      )
          ->join('documento_detalle', 'documentos.id_documento', '=', 'documento_detalle.documento_id')
          ->join('empresa_tercero', 'empresa_tercero.tercero_id', '=', 'documentos.tercero_id')
          ->where('documentos.id_documento',$id)
          ->where('documento_detalle.deleted',0)
          ->get();
      return response()->json($documentos,200);
   }

   function create(Request $request){
      $total_doc = Documento::all()
      ->where('deleted',0)
      ->where('status','!=','INCOMPLETO')
      ->count();
      $total_doc = $total_doc+1;
      if ($total_doc<=9) {
        $consecutivo_doc = "000".$total_doc;
      }elseif($total_doc>=10 && $total_doc<100){
        $consecutivo_doc = "00".$total_doc;
      }elseif($total_doc>=100 && $total_doc<1000){
        $consecutivo_doc = "0".$total_doc;
      }elseif($total_doc>=1000 && $total_doc<10000){
        $consecutivo_doc = $total_doc;
      }
      DB::beginTransaction();
      try{
         $user=Auth()->user();
            $id_documento;
            if ($request->id_documento == 0) {
               $documento = new Documento;
               $documento->empresa_id   = $user->empresa_id;
               $documento->tercero_id   = $request->id_tercero;
               $documento->no_documento = $consecutivo_doc;
               $documento->fecha        = '2020-08-12 00:00:00';
               $documento->subtotal     = '0';
               $documento->descuento    = '0';
               $documento->iva          = '0';
               $documento->total        = '0';
               $documento->observacion  = '';
               $documento->status       = 'INCOMPLETO';
               $documento->deleted      = '0';
               $documento->save();
               $id_documento = $documento->id_documento;
            }else{
               $id_documento = $request->id_documento;
            }
            $documento_d = new Documento_detalle;
            $documento_d->documento_id   = $id_documento;
            $documento_d->tipo_documento = $request->tipo_documento;
            $documento_d->cantidad       = $request->cantidad;
            $documento_d->descripcion    = $request->descripcion;
            $documento_d->val_unitario   = $request->costos;
            $documento_d->val_total      = $request->costos;
            $documento_d->costo          = $request->costos;
            $documento_d->tipo_papel_id  = $request->tipo_papel;
            $documento_d->tipo_maquina_id= $request->val_tip_maq;
            $documento_d->deleted        = 0;
            $documento_d->save();
               $item = new ItemSencillo;
               $item->detalle_id       = $documento_d->id_detalle;
               $item->tamanoH          = $request->tam_1;
               $item->tamano_v         = $request->tam_2;
               $item->cant_montaje     = 0;
               $item->corte_papel_h    = "";
               $item->corte_papel_y    = "";
               $item->num_tinta_tiro   = $request->tinta_1;
               $item->num_tinta_retiro = $request->tinta_2;
               $item->vr_diseno        = $request->val_diseno;
               $item->vr_trasporte     = $request->transporte;
               $item->vr_rifle         = $request->val_rifle;
               $item->inicio_num       = "";
               $item->save();
               if ($request->hayAcabado) {
                  for ($i=1; $i < 10; $i++) {
                     $detalleAcabado = new DetalleAcabado;
                     if ($request->{"num_acabado$i"} == true) {
                        $detalleAcabado->detalle_id= $documento_d->id_detalle;
                        $detalleAcabado->acabado_id = $i;
                        $detalleAcabado->save();
                     }
                  }
               }
         DB::commit();
         return response()->json($id_documento ,200);
      }catch (\Exception $e){
         DB::rollback();
         return response()->json($e,400);
      }
   }

   function edit(Request $request){
      $documentos = Documento::select(
         "documentos.id_documento",
         "documento_detalle.id_detalle",
         "documento_detalle.cantidad",
         "documento_detalle.descripcion",
         "documento_detalle.val_unitario",
         "itemsencillos.vr_diseno",
         "itemsencillos.vr_rifle",
         "itemsencillos.tamanoH",
         "itemsencillos.tamano_v",
         "itemsencillos.num_tinta_tiro",
         "itemsencillos.num_tinta_retiro",
         "itemsencillos.vr_trasporte",
         "documento_detalle.tipo_papel_id",
         "documento_detalle.tipo_maquina_id",
         "maquina.precio_millar",
         "documento_detalle.costo",
         "papel.precio as precio_papel",
         "det_a.acabado_id"
      )
         ->join('documento_detalle', 'documentos.id_documento', '=', 'documento_detalle.documento_id')
         ->join('itemsencillos', 'itemsencillos.detalle_id', '=', 'documento_detalle.id_detalle')
         ->leftJoin('tipo_maquinas as maquina', 'maquina.id_tipo_maquina','=', 'documento_detalle.tipo_maquina_id')
         ->leftJoin('tipo_papeles as papel', 'papel.id_tipo_papel','=', 'documento_detalle.tipo_papel_id')
         ->leftJoin('detalle_acabado as det_a', 'det_a.detalle_id','=', 'documento_detalle.id_detalle')
         ->leftJoin('acabados as acabado', 'acabado.id_acabado','=', 'det_a.acabado_id')
          ->where('documentos.id_documento',$request->id_documento)
          ->where('documento_detalle.id_detalle',$request->id_detalle)
          ->get();
      return response()->json($documentos,200);
   }

   function update(Request $request){
      $id_documento = $request->id_documento;
      $actualizar = Documento::where('id_documento', $id_documento)
      ->update([
         'subtotal' => $request->subtotal,
         'descuento' => $request->descuento,
         'iva' => $request->iva,
         'total' => $request->total,
         'status' =>$request->status
      ]);
      return response()->json($id_documento ,200);
   }
   function actualizarItem(Request $request){
      $id_detalle = $request->id_item_;
      $actualizar = Documento_detalle::where('id_detalle', $id_detalle)
      ->update([
         'cantidad' => $request->cantidad,
         'val_unitario' => $request->costos,
         'val_total' => $request->costos,
         'descripcion' => $request->descripcion,
         'costo' =>$request->costos,
         'tipo_papel_id' => $request->tipo_papel,
         'tipo_maquina_id' => $request->val_tip_maq,
      ]);
      if ($request->hayAcabado) {
         $IsExiste =DetalleAcabado::where('detalle_id', '=', $id_detalle)->delete();
         for ($i=1; $i < 10; $i++) {
            $detalleAcabado = new DetalleAcabado;
            if ($request->{"num_acabado$i"} == true) {
               $detalleAcabado->detalle_id= $id_detalle;
               $detalleAcabado->acabado_id = $i;
               $detalleAcabado->save();
            }
         }
      }
      return response()->json($id_detalle ,200);
   }
   function deleted(Request $request){
      $id_documento = $request->iddocumento;
      $actualizar = Documento::where('id_documento', $id_documento)
      ->update([
         'deleted' => 1
      ]);
      return response()->json($id_documento ,200);
   }
   function delete_item(Request $request){
      // $id_documento = $request->id_detalle;
      $actualizar = Documento_detalle::where('id_detalle', $request->id_detalle)
      ->update([
         'deleted' => 1
      ]);
      return response()->json($request->id_detalle ,200);
   }
}





