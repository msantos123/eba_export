<?php

namespace App\Http\Controllers;

use App\Models\SigaSalidaDetalle;
use App\Models\SalidaInventarioDetalle;
use App\Models\Carga;
use Illuminate\Http\Request;

class SigaSalidaDetalleController extends Controller
{
    public function verCargaPlanta($id)//uso
    {
        $verCargaPlanta = SigaSalidaDetalle::select('export.siga_salida_detalles.*',
        'siga.insumo_receta.rece_codigo as rece_codigo','siga.insumo_receta.rece_nombre')
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','export.siga_salida_detalles.rece_id')
        ->where('cargaIngreso_id',$id)->get();

        return response()->json($verCargaPlanta);
    }

    public static function verSalidaPlanta($id)//uso
    {
        $verSalidaPlanta = SalidaInventarioDetalle::select('siga.producto_terminado_movimiento_detalle.*',
        'siga.insumo_receta.rece_codigo as rece_codigo','siga.insumo_receta.rece_nombre')
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','siga.producto_terminado_movimiento_detalle.mvdpt_rece_id')
        ->where('siga.producto_terminado_movimiento_detalle.mvdpt_cantidad','!=',0)
        ->where('siga.producto_terminado_movimiento_detalle.mvdpt_mvpt_id',$id)
        ->orderby('siga.producto_terminado_movimiento_detalle.mvdpt_lote', 'asc')
        ->get();

        return response()->json($verSalidaPlanta);
    }

    public function selectFechaAlmacen ($id)//USO
    {
        //AREGLAR ESTAS FECHAS
        $carga = Carga::where('id',$id)->first();
        $cargaLote = $carga->lote;
        $cargaReceta = $carga->receta_id;
        $verAlmacenDetalle = SigaSalidaDetalle::select('export.siga_salida_detalles.*',
        'siga.insumo_receta.rece_codigo as rece_codigo','siga.insumo_receta.rece_nombre')
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','export.siga_salida_detalles.rece_id')
        ->where('cargaSalida_id',null)
        ->where('lote_detalle',$cargaLote)
        //->where('rece_id',$cargaReceta)
        ->get();

        return response()->json($verAlmacenDetalle);
    }

    public function selectIds($cargaId, Request $request) //uso
    {
    $inputArray = $request->input('inputs');
    foreach ($inputArray as $input) {
        $id = $input['id'];
        $cantidadSolicitada = $input['cantidad'];

        $registro = SigaSalidaDetalle::find($id);
        if ($registro != null) {
            // Verificar si la cantidad detallada es menor que la cantidad solicitada
            if ($registro->cantidad_detalle > $cantidadSolicitada) {
                // Crear un nuevo registro con la cantidad restante
                $nuevaCantidad = $registro->cantidad_detalle - $cantidadSolicitada;
                // Aquí se asume que tienes un modelo Carga para crear un nuevo registro
                SigaSalidaDetalle::create([
                    'detalle_id' => $registro->detalle_id,
                    'salida_id' => $registro->salida_id,
                    'rece_id' => $registro->rece_id,
                    'cantidad_detalle' => $nuevaCantidad,
                    'lote_detalle' => $registro->lote_detalle,
                    'fecha_elaboracion' => $registro->fecha_elaboracion,
                    'fecha_vencimiento' => $registro->fecha_vencimiento,
                    'fecha_envasado' => $registro->fecha_envasado,
                    'cargaIngreso_id' => $registro->cargaIngreso_id,
                     //Agrega otros campos según sea necesario
                ]);
            }
        //Actualizar el registro existente
        $registro->cantidad_salida = $cantidadSolicitada;
        $registro->save();
        $registro->cargaSalida_id = $cargaId;
        $registro->save();
        }
    }
    $carga = Carga::find($cargaId);
    $carga->estado = 1;
    $carga->save();

    return response()->json($cargaId);
}

    public function viewSelectIds ($id)//uso
    {
        $verSelectIds = SigaSalidaDetalle::select('export.siga_salida_detalles.*',
        'siga.insumo_receta.rece_codigo as rece_codigo','siga.insumo_receta.rece_nombre')
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','export.siga_salida_detalles.rece_id')
        ->where('cargaSalida_id',$id)
        ->get();

        return response()->json($verSelectIds);
    }

}
