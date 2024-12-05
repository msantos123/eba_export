<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $fillable = [
        'ctrt_codigo',
        'ctrt_fecha',
        'ctrt_contenido',
        'ctrt_estado',
        'pdf_contrato',
    ];

    public static function generarCodigoContrato()//uso
    {
        $lastDocument = Contrato::whereNotNull('ctrt_codigo')
        ->latest('contratos.id')
        ->first();

        $currentYear = date('y');

        if ($lastDocument !== null)
        {
            $lastNumber = (int) substr($lastDocument->ctrt_codigo, -4);
            $codigo = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
        }else{
            $codigo = '001/'.$currentYear;
        }
        return $codigo;
    }
}
