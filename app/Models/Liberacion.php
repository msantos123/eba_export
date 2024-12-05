<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liberacion extends Model
{
    use HasFactory;
    protected $table = 'liberaciones';
    protected $fillable = [
        'libe_usu',
        'libe_nave_viaje',
        'libe_bl',
        'libe_puerto',
        'libe_consignatario',
        'libe_direccion',
        'libe_factura',
        'nro_documento',
        'pdf_documento',
        'libe_estado',
    ];
}
