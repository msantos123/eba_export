<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\DetalleKardex;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KardexController extends Controller
{

    public function index()
    {
        $kardex = Kardex::select('kardexes.id','codigo_producto',
        'articulo','proveedor_id','unidad','lote','saldo')
        ->orderBy('codigo_producto', 'asc')
        ->get();
        return Inertia::render('Kardex/Index', [
            'kardex' => $kardex,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        foreach ($request->cargas as $index => $carga) {
            $kardex = Kardex::create([
                'codigo_producto' => $request->cargas[$index]['codigo_producto'],
                'articulo' => $request->cargas[$index]['nombre_producto'],
                'proveedor_id' => $request->input('planta_id'),
                'ubicacion' => 'Almacen EBA El Alto',
                'lote' => $request->cargas[$index]['lote'],
                'saldo' => $request->cargas[$index]['cantidad']
            ]);

            $detallekardex = DetalleKardex::create([
                'kardex_id' => $kardex->id,
                'tipo_movimiento' => 'Ingreso',
                'empresa' => $request->input('empresa'),
                'codigo_conocimiento' => $request->input('codigo_conocimiento'),
                'ingreso_id' => $request->input('id_ingreso'),
                'ingreso' => $request->cargas[$index]['cantidad'],
            ]);
        }
        return redirect('comprobante_ingreso');
    }

    public function show(Kardex $kardex)
    {
        $detallekardex = DetalleKardex::select('detalle_kardexes.*','kardexes.saldo as saldo','comprobante_ingresos.fecha_ingreso as fechaIngreso',
        'comprobante_ingresos.codigo_ingreso as codigoIngreso')
        ->join('kardexes','kardexes.id','=','detalle_kardexes.kardex_id')
        ->join('comprobante_ingresos','comprobante_ingresos.id','=','detalle_kardexes.ingreso_id')
        ->where('detalle_kardexes.kardex_id',$kardex->id)->get();
        //dd($detallekardex);
        return Inertia::render('Kardex/Edit', [
            'kardex' => $kardex,
            'detallekardex' => $detallekardex,
        ]);
    }

    public function edit(Kardex $kardex)
    {
        dd($kardex);
    }

    public function update(Request $request, Kardex $kardex)
    {
        dd('update');
    }

    public function destroy(Kardex $kardex)
    {
        //
    }
}
