<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_producto',
        'nombre_producto',
        'fecha_produccion',
        'descripcion',
        'lote',
        'cantidad',
        'kilosnetos',
        'librasnetas',
        'solicitud_cargas',
    ];
}
