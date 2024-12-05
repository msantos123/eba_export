<?php

namespace App\Http\Controllers;

use App\Models\ComprobanteSalida;
use App\Models\kardex;
use App\Models\Detallekardex;
use App\Models\Producto;
use App\Models\DetalleSalida;
use App\Models\Carga;
use App\Models\Solicitudcarga;
use Illuminate\Http\Request;
use App\Http\Requests\ComprobanteSalidaRequest;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ComprobanteSalidaController extends Controller
{
    public function index()//uso
    {
        $comprobanteSalida = ComprobanteSalida::all();
        return Inertia::render('ComprobanteSalida/Index', [
            'comprobanteSalida' => $comprobanteSalida,
        ]);
    }

    public function createSalida($id)//uso
    {
        $comprobanteSalidas = ComprobanteSalida::all();
        $codigo = ComprobanteSalida::generarCodigoSalida();
        $cargas = Carga::where('solicitud_cargas',$id)->get();

        return Inertia::render('ComprobanteSalida/Create', [
            'codigo' => $codigo,
            'comprobanteSalidas' => $comprobanteSalidas,
            'cargas' => $cargas,
            'solicitud_id' => $id,
        ]);
    }

    public function store(ComprobanteSalidaRequest $request)//uso
{
    try {
        $salida = ComprobanteSalida::create([
            'fecha_salida' => $request['fecha_salida'],
            'empresa' => $request['empresa'],
            'responsable' => $request['responsable'],
            'camion' => $request['camion'],
            'placa' => $request['placa'],
            'licencia' => $request['licencia'],
            'celular' => $request['celular'],
            'contenedor' => $request['contenedor'],
            'presinto' => $request['presinto'],
            'reserva' => $request['reserva'],
            'factura' => $request['factura'],
            'destino' => $request['destino'],
            'codigo_salida' => $request['codigo_salida'],
        ]);

        $solicitudcarga = Solicitudcarga::find($request->solicitud_id);
        $solicitudcarga->fill([
            'salida_inventario' => $salida->id,
            'estado' => 2,
        ]);
        $solicitudcarga->save();

        foreach ($request->input('cargas') as $detail) {
            $kardex_id = $detail['kardex_id'];
            Detallekardex::create([
                'kardex_id' => $kardex_id,
                'tipo_movimiento' => 'Salida',
                'empresa' => $request->empresa,
                'salida_id' => $salida->id,
                'salida' => $detail['cantidad'],
            ]);

            $kardex = Kardex::find($kardex_id);
            if ($kardex) {
                $kardex->saldo -= $detail['cantidad'];
                $kardex->save();
            }
        }

        return redirect()->route('comprobante_salida.index')->with('success', 'Comprobante de salida creado exitosamente.');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['message' => 'Error al crear el comprobante de salida: ' . $e->getMessage()]);
    }
}

    public function show($id)//uso
    {
        $comprobanteSalida = ComprobanteSalida::where('id', $id)->first();
        $solicitudcarga = Solicitudcarga::where('salida_inventario', $comprobanteSalida->id)->first();
        $cargas = Carga::where('solicitud_cargas',$solicitudcarga->id)->get();
        return Inertia::render('ComprobanteSalida/Show', [
            'comprobanteSalida' => $comprobanteSalida,
            'cargas' => $cargas,
        ]);
    }

    public function pdf($id)//uso
    {
        $comprobanteSalida = ComprobanteSalida::pdfSalida($id);

        $cargas =  Carga::where('solicitud_cargas', $comprobanteSalida->solicitud_id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');
        $pdf = $pdf->loadView('comprobante-salida', compact('comprobanteSalida', 'cargas'));
        return $pdf->stream('ComprobanteSalida.pdf');
    }

    public function upload(Request $request)//uso
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'comprobante_id' => 'required|integer',
        ]);

        try {
            $file = $request->file('file');
            $comprobanteId = $request->input('comprobante_id');

            $uniqueFileName = "comprobante_salida_{$comprobanteId}_" . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/comprobante_salida', $uniqueFileName);

            $comprobanteSalida = ComprobanteSalida::find($comprobanteId);
            $comprobanteSalida->pdf_comprobante_salida = $uniqueFileName;
            $comprobanteSalida->save();

            return response()->json([
                'path' => $uniqueFileName,
                'file_name' => $uniqueFileName
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




}
