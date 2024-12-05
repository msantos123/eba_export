<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SigaSalidaDetalle extends Model
{
    use HasFactory;
    protected $fillable = [
        'detalle_id',
        'salida_id',
        'rece_id',
        'cantidad_detalle',
        'cantidad_salida',
        'lote_detalle',
        'fecha_elaboracion',
        'fecha_vencimiento',
        'fecha_envasado',
        'cargaIngreso_id',
        'cargaSalida_id',
    ];

    public static function verSigaSalidaDetalle ($salida_inventario)//uso
    {
        $salidaDetalle = SigaSalidaDetalle::select('export.siga_salida_detalles.salida_id','siga.insumo_receta.rece_codigo as rece_codigo',
        'siga.insumo_receta.rece_nombre as rece_nombre','export.siga_salida_detalles.lote_detalle','export.siga_salida_detalles.cantidad_detalle',
        'export.siga_salida_detalles.fecha_elaboracion','export.siga_salida_detalles.fecha_vencimiento','export.siga_salida_detalles.fecha_envasado',
        DB::raw('SUM(siga_salida_detalles.cantidad_detalle) as total_cantidad_detalle'))
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','export.siga_salida_detalles.rece_id')
        ->groupBy('export.siga_salida_detalles.salida_id','insumo_receta.rece_codigo','insumo_receta.rece_nombre','siga_salida_detalles.lote_detalle',
        'siga_salida_detalles.cantidad_detalle','siga_salida_detalles.fecha_elaboracion','siga_salida_detalles.fecha_vencimiento','siga_salida_detalles.fecha_envasado')
        ->where('salida_id',$salida_inventario)->get();

        return $salidaDetalle;
    }



}
