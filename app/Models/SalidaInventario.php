<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaInventario extends Model
{
    use HasFactory;
    protected $table = 'siga.producto_terminado_movimiento';
    protected $fillable = [
        'mvpt_id',
        'mvmvpt_datos',
        'mvmvpt_tipo',
        'mvmvpt_tipo_det',
        'mvmvpt_estado',
        'mvmvpt_nro',
        'mvmvpt_env_id',
        'mvmvpt_planta_id',
        'usr_registrado',
        'usr_modificado',
        'usr_eliminado',
        'created_at',
        'updated_at',
        'deleted_at',
        'mvmvpt_estado_mov',
        'mvmpt_detalle',
    ];

    public static function indexSalidaInventario ($planta_id)//uso
    {
        $salidaInventario = SalidaInventario::select(
            'siga.producto_terminado_movimiento.mvpt_id',
            'producto_terminado_movimiento.mvmvpt_nro',
            'producto_terminado_movimiento.created_at',
            'producto_terminado_movimiento.mvmvpt_tipo',
            'producto_terminado_movimiento.mvmvpt_tipo_det')
        ->where('siga.producto_terminado_movimiento.mvmvpt_planta_id',$planta_id)
        ->where('siga.producto_terminado_movimiento.mvmvpt_tipo','SALIDA')
        ->where('siga.producto_terminado_movimiento.mvmvpt_tipo_det','EXPORTACIÓN')
        ->where('siga.producto_terminado_movimiento.mvmvpt_estado','A')
        ->orderBy('siga.producto_terminado_movimiento.mvmvpt_nro','desc')
        ->with(['SalidaDetalle' => function ($query) {
                $query->select('mvdpt_mvpt_id', 'mvdpt_lote', 'mvdpt_rece_id', 'insumo_receta.rece_nombre as rece_nombre',
                \DB::raw('SUM(mvdpt_cantidad) as total_cantidad'))
                ->join('siga.insumo_receta','insumo_receta.rece_id','=','mvdpt_rece_id')
                ->groupBy('mvdpt_mvpt_id', 'mvdpt_lote', 'mvdpt_rece_id', 'rece_nombre');
        }])
        ->get();
        return $salidaInventario;
    }

    public function SalidaDetalle() //uso
    {
        return $this->hasMany(SalidaInventarioDetalle::class,
        'mvdpt_mvpt_id',
        'mvpt_id');
    }


}
