<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventario extends Model
{
    use HasFactory;
    protected $table = 'siga.stock_existencia_pt';
    protected $fillable = [
        'skpt_id',
        'skpt_rece_id',
        'skpt_cantidad',
        'skpt_costo',
        'skpt_lote',
        'skpt_fec_vencimiento',
        'skpt_estado',
        'skpt_planta_id',
        'usr_registrado',
        'usr_modificado',
        'usr_eliminado',
        'skpt_fec_elaboracion',
        'skpt_fec_envasado',
    ];

    public static function indexInventario()//uso
    {
        $inventario = Inventario::select(
            'siga.stock_existencia_pt.skpt_rece_id',
            'siga.insumo_receta.rece_nombre as rece_nombre',
            'siga.stock_existencia_pt.skpt_planta_id',
            DB::raw('SUM(siga.stock_existencia_pt.skpt_cantidad) as total_cantidad'),
            DB::raw('COUNT(siga.stock_existencia_pt.skpt_rece_id) as total_rece_id'),
        )
        ->join('siga.insumo_receta', 'siga.insumo_receta.rece_id', '=', 'siga.stock_existencia_pt.skpt_rece_id')
        ->where('siga.stock_existencia_pt.skpt_cantidad', '!=', 0)
        ->whereIn('siga.stock_existencia_pt.skpt_planta_id', [9,10,25])
        ->groupBy('siga.stock_existencia_pt.skpt_planta_id','siga.stock_existencia_pt.skpt_rece_id', 'siga.insumo_receta.rece_nombre')
        ->orderBy('rece_nombre','asc')
        ->get();

        return $inventario;
    }

    public static function showInventario($producto,$planta)//uso
    {
        $showInventario = Inventario::select('siga.stock_existencia_pt.*',
        'siga.insumo_receta.rece_codigo as rece_codigo','siga.insumo_receta.rece_nombre as rece_nombre')
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','siga.stock_existencia_pt.skpt_rece_id')
        ->where('skpt_rece_id',$producto)->where('skpt_planta_id',$planta)
        ->where('stock_existencia_pt.skpt_cantidad', '!=', 0)
        ->get();

        return $showInventario;
    }

    public static function productoPlanta($planta_id)
    {
        $inventario = Inventario::select(
            'siga.stock_existencia_pt.skpt_rece_id',
            'siga.insumo_receta.rece_codigo as rece_codigo',
            'siga.insumo_receta.rece_nombre as rece_nombre',
            'siga.stock_existencia_pt.skpt_planta_id',
            'siga.stock_existencia_pt.skpt_lote',
            DB::raw('SUM(siga.stock_existencia_pt.skpt_cantidad) as total_cantidad'),
            DB::raw('COUNT(siga.stock_existencia_pt.skpt_rece_id) as total_rece_id'),
            DB::raw('COUNT(siga.stock_existencia_pt.skpt_lote) as total_lote'),
        )
        ->join('siga.insumo_receta', 'siga.insumo_receta.rece_id','=','siga.stock_existencia_pt.skpt_rece_id')
        ->where('siga.stock_existencia_pt.skpt_cantidad', '!=', 0)
        ->where('siga.stock_existencia_pt.skpt_planta_id', $planta_id)
        ->groupBy('siga.stock_existencia_pt.skpt_planta_id','siga.stock_existencia_pt.skpt_rece_id',
        'siga.insumo_receta.rece_codigo','siga.insumo_receta.rece_nombre','siga.stock_existencia_pt.skpt_lote')
        ->orderBy('rece_nombre','asc')
        ->orderBy('skpt_lote','asc')
        ->get();

        return $inventario;
    }

}
