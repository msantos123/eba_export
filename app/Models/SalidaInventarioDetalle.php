<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaInventarioDetalle extends Model
{
    use HasFactory;
    protected $table = 'siga.producto_terminado_movimiento_detalle';
    protected $fillable = [
        'mvdpt_id',
        'mvdpt_mvpt_id',
        'mvdpt_rece_id',
        'mvdpt_cantidad',
        'mvdpt_costo',

        'mvdpt_lote',
        'mvdpt_fec_vencimiento',
        'mvdpt_estado',
        'usr_registrado',
        'usr_modificado',
        'usr_eliminado',

        'created_at',
        'updated_at',
        'deleted_at',

        'mvdpt_tipo_paquete',
        'mvdpt_skpt_id',
        'mvdpt_fec_elaboracion',
        'mvdpt_fec_envasado',
        'mvdpt_cantidad_saldo',
        'mvdpt_id_product_faceba',
        'mvdpt_datos',

    ];

    public static function verSalidaPlanta($id)//uso
    {
        $verSalidaPlanta = SalidaInventarioDetalle::select('siga.producto_terminado_movimiento_detalle.*',
        'siga.insumo_receta.rece_codigo as rece_codigo','siga.insumo_receta.rece_nombre')
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','siga.producto_terminado_movimiento_detalle.mvdpt_rece_id')
        ->where('siga.producto_terminado_movimiento_detalle.mvdpt_cantidad','!=',0)
        ->where('siga.producto_terminado_movimiento_detalle.mvdpt_mvpt_id',$id)
        ->orderby('siga.producto_terminado_movimiento_detalle.mvdpt_lote', 'asc')
        ->get();

        return $verSalidaPlanta;
    }
}
