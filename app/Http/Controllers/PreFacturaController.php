<?php

namespace App\Http\Controllers;
use App\Models\PreFactura;
use App\Models\ComprobanteSalida;
use App\Models\Carga;
use Illuminate\Http\Request;
use App\Http\Requests\PreFacturaRequest;
use Inertia\Inertia;


class PreFacturaController extends Controller
{
    public function index ()
    {
        $pre_factura = PreFactura::select('pre_facturas.id',
        'pre_facturas.nro_factura','pre_facturas.fecha_factura','pre_facturas.razon_social',
        'pre_facturas.lugar_destino','pre_facturas.zafra','pre_facturas.anulado')
        ->orderBy('fecha_factura', 'desc')
        ->orderBy('nro_factura', 'desc')
        ->get();
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
        return Inertia::render('PreFactura/Show',[
            'pre_factura' => $pre_factura,
        ]);
    }

    public function create($id)
    {
        $comprobante_salida = ComprobanteSalida::with([
            'solicitudCarga.cargas'
        ])
        ->where('id', $id)
        ->first();
        return Inertia::render('PreFactura/Create',[
            'comprobante_salida' => $comprobante_salida,
        ]);
    }

    public function store(PreFacturaRequest $request)
    {
        $data = $request->validated();
        $pre_factura = PreFactura::create($data);

        if (isset($request['cargasDetails']) && is_array($request['cargasDetails'])) {
            foreach ($request['cargasDetails'] as $cargaData) {
                $precioKilo = 0;
                $precioLibra = 0;

                if ($cargaData['medida'] === 'KG') {
                    $precioKilo = $cargaData['precio'];
                    $precioLibra = $cargaData['precio'] * 2.20462;
                } elseif ($cargaData['medida'] === 'LB') {
                    $precioLibra = $cargaData['precio'];
                    $precioKilo = $cargaData['precio'] / 2.20462;
                }
                Carga::where('id', $cargaData['id'])->update([
                    'precio_kilo' => $precioKilo,
                    'precio_libra' => $precioLibra,
                ]);
            }
        }

        try {
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
