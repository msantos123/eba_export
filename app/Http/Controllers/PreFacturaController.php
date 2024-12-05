<?php

namespace App\Http\Controllers;
use App\Models\PreFactura;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PreFacturaController extends Controller
{
    public function index ()
    {
        $pre_factura = PreFactura::select('pre_facturas.id',
        'pre_facturas.nro_factura','pre_facturas.fecha_factura','pre_facturas.razon_social',
        'pre_facturas.lugar_destino','pre_facturas.zafra','pre_facturas.anulado')
        ->orderBy('id', 'desc')->get();
        return Inertia::render('PreFactura/Index',[
            'pre_factura' => $pre_factura,
        ]);
    }

    public function show($id)
    {
        $pre_factura = PreFactura::with([
            'comprobanteSalida.solicitudCarga.cargas'
        ])
        ->where('id', $id)
        ->first();
        //dd($pre_factura);
        return Inertia::render('PreFactura/Show',[
            'pre_factura' => $pre_factura,
        ]);
    }
}
