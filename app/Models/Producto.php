<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
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
}
