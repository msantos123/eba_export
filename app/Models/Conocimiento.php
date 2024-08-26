<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Solicitudcarga;
use App\Models\Carga;

class Conocimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'usuario_id',
        'empresa',
        'conductor',
        'vehiculo',
        'propietario',
        'licencia',
        'placa',
        'celular',
        'solicitud_id',
        'estado',
    ];

    public static function generarCodigoConocimiento($request)
    {
        //dd($request->planta_id);
        $lastDocument = Conocimiento::select('conocimientos.codigo')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->where('solicitudcargas.planta_id', $request->planta_id)
        ->whereNotNull('conocimientos.codigo')
        ->latest('conocimientos.id')
        ->first();

        //dd($lastDocument);

        $currentYear = date('y');

        if ($lastDocument!==null) {
            $lastNumber = (int) substr($lastDocument->codigo, -4);
            $codigo = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
            //dd($codigo);
        } else {
            $codigo = '001/'.$currentYear;
        }
        return $codigo;
    }

    public function carga()
    {
    return $this->hasOne(Carga::class, 'solicitud_id', 'solicitud_id');
    }

}
