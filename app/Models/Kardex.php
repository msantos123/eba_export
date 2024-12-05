<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_producto',
        'articulo',
        'proveedor_id',
        'ubicacion',
        'unidad',
        'lote',
        'saldo',
        'receta_id',
    ];

    public static function productoKardex ($planta_id)//uso
    {
        $productoKardex = Kardex::select('kardexes.*')
        ->where('kardexes.proveedor_id',$planta_id)->get();

        return $productoKardex;
    }
}
