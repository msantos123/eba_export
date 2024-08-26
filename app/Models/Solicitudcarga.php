<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carga;

class Solicitudcarga extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'usuario_id',
        'planta_id',
        'estado',
    ];

    public static function generarCodigoSol($request)
    {
        $lastDocument = Solicitudcarga::select('solicitudcargas.id','codigo')
        ->where('solicitudcargas.planta_id', $request->planta_id)
        ->whereNotNull('codigo')
        ->latest('solicitudcargas.id')
        ->first();
        $currentYear = date('y');
        if ($lastDocument !== null) {
            $lastNumber = (int) substr($lastDocument->codigo, -4);
            $codigo = 'SOL-'.str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
        } else {
            $codigo = 'SOL-001/'.$currentYear;
        }
        return $codigo;
    }

    public function cargas()
    {
        return $this->hasMany(Carga::class, 'solicitud_id');
    }
}
