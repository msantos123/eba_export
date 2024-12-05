<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleKardex extends Model
{
    use HasFactory;
    protected $fillable = [
        'kardex_id',
        'fecha_produccion',
        'tipo_movimiento',
        'empresa',
        'codigo_conocimiento',
        'ingreso_id',
        'salida_id',
        'ingreso',
        'salida'
    ];
}
