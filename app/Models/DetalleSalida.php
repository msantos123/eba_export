<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ComprobanteSalida;

class DetalleSalida extends Model
{
    use HasFactory;
    protected $fillable = [
        'salida_id',
        'kardexs_id',
        'codigo_producto',
        'producto',
        'lote',
        'cantidad',
    ];
}
