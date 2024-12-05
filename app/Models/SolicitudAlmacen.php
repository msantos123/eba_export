<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Solicitudcarga;
use App\Models\Carga;
use App\Models\SigaSalidaDetalle;

class SolicitudAlmacen extends Model
{
    use HasFactory;

    protected $fillable = [
        'planta_id',
        'usuario_id',
        'tipo',
        // Agrega aquí otros campos que necesites
    ];
    public static function fechaElaboracion($id)
    {
        $cargas = Carga::select('cargas.*')
        ->where('solicitud_cargas',$id)
        ->with('cargas_sigaSalidaDetalle')
        ->get();

        return $cargas;
    }

}
