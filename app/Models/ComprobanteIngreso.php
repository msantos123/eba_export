<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conocimiento;
use App\Models\Solicitudcarga;
use App\Models\Carga;

class ComprobanteIngreso extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_ingreso',
        'fecha_ingreso',
        'cefo',
        'observaciones',
        'conocimiento_id',
    ];

    public static function generarCodigoIngreso($id)
    {
        $lastDocument = ComprobanteIngreso::whereNotNull('codigo_ingreso')
        ->latest('comprobante_ingresos.id')
        ->first();

        $currentYear = date('y');

        if ($lastDocument !== null)
        {
            $lastNumber = (int) substr($lastDocument->codigo_ingreso, -4);
            $codigo = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
        }else{
            $codigo = '001/'.$currentYear;
        }
        return $codigo;
    }

    public function conocimiento()
    {
    return $this->hasOne(Conocimiento::class, 'id','conocimiento_id');
    }

    public function vercargas()
    {
    return $this->hasManyThrough(
        Carga::class,
        Conocimiento::class,
        'id', // Clave Primaria de Conocimiento
        'solicitud_cargas', // Clave foránea en Carga
        'id', // Clave primaria de ComprobanteIngreso
        'solicitud_id' // Clave foranea en conocimiento
    );
    }


}
