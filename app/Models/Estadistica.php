<?php

namespace App\Models;

use App\Models\Estadistica;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadistica extends Model
{
    use HasFactory;
    protected $fillable = [
        'gestion',
        'mes',
        'contrato',
        'cliente_contrato',
        'nro_factura',
        'fecha_factura',
        'cliente',
        'destino',
        'puerto',
        'incoterm',
        'calidad',
        'zafra',
        'cantidad_caja',
        'volumen_kg',
        'volumen_tn',
        'precio',
        'total_facturado_usd',
        'total_facturado_oficial',
        'comisiones',
        'total_pagar_usd',
        'ingreso_total_eba',
        'total_pagado_bs',
    ];
}
