<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $fillable = [
        'eti_usuario',
        'eti_nombre',
        'eti_contenido',
    ];

    public static function etiquetasIndex ()//uso
    {
        $comprobanteSalida = ComprobanteSalida::select('comprobante_salidas.*')
        ->with(['solicitudCargas' => function ($query)
        {
            $query->where('tipo', 'SALIDA');
        }, 'solicitudCargas.cargas'])
        ->get();

        return $comprobanteSalida;
    }
}
