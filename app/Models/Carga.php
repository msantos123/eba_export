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
        'costo',
        'kilosnetos',
        'librasnetas',
        'receta_id',
        'solicitud_cargas',
        'kardex_id',
        'estado',
    ];

    public function cargas_sigaSalidaDetalle ()
    {
        return $this->hasMany(SigaSalidaDetalle::class,'cargaSalida_id','id');
    }


}
