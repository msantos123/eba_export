<?php

namespace App\Imports;

use App\Models\Estadistica;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstadisticasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Estadistica([
            'gestion' => (int) $row['gestion'],
            'mes' => $row['mes'],
            'contrato' => $row['contrato'],
            'cliente_contrato' => $row['cliente_contrato'],
            'nro_factura' => (int) $row['nro_factura'],
            'fecha_factura' => \Carbon\Carbon::parse($row['fecha_factura']),
            'cliente' => $row['cliente'],
            'destino' => $row['destino'],
            'puerto' => $row['puerto'],
            'incoterm' => $row['incoterm'],
            'calidad' => $row['calidad'],
            'zafra' => $row['zafra'],
            'cantidad_caja' => (int) $row['cantidad_caja'],
            'volumen_kg' => (int) $row['volumen_kg'],
            'volumen_tn' => (int) $row['volumen_tn'],
            'precio' => (float) $row['precio'],
            'total_facturado_usd' => (float) $row['total_facturado_usd'],
            'total_facturado_oficial' => (float) $row['total_facturado_oficial'],
            'comisiones' => (float) $row['comisiones'],
            'total_pagar_usd' => (float) $row['total_pagar_usd'],
            'ingreso_total_eba' => (float) $row['ingreso_total_eba'],
            'total_pagado_bs' => (float) $row['total_pagado_bs'],
        ]);
    }
}
