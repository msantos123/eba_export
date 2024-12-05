<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreFactura extends Model
{
    use HasFactory;
    protected $fillable = [
        'comprobante_salida',
        'mes',
        'fecha_factura',
        'nro_factura',
        'razon_social',
        'nit',
        'incoterm',
        'lugar_destino',
        'puerto_destino',
        'direccion',
        'tipo_cambio',
        'zafra',
        'total_facturado_usd',
        'total_facturado_bs',
        'comision',
        'total_pagar_usd',
        'total_pagar_bs',
        'primer_pago',
        'fecha_primer_pago',
        'segundo_pago',
        'fecha_segundo_pago',
        'tercer_pago',
        'fecha_tercer_pago',
        'total_pagos',
        'saldos',
        'anulado',
    ];

    public function comprobanteSalida()
    {
        return $this->belongsTo(ComprobanteSalida::class, 'comprobante_salida', 'id');
    }


}
