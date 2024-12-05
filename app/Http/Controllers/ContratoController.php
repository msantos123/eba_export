<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Requests\ContratoRequest;
use Inertia\Inertia;
use App\Models\Contrato;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Str;

class ContratoController extends Controller
{
    public function index ()//uso
    {
        $contratos = Contrato::all();
        return Inertia::render('Contratos/Index', [
            'contratos' => $contratos,
        ]);
    }

    public function create ()//uso
    {
        return Inertia::render('Contratos/Create');
    }

    public function store (ContratoRequest $request)//uso
    {
        $validatedData = $request->validated();

        $contenido = [
            'ctrt_vendedor' => $validatedData['ctrt_vendedor'],
            'ctrt_comprador' => $validatedData['ctrt_comprador'],
            'ctrt_direccion_comprador' => $validatedData['ctrt_direccion_comprador'],
            'ctrt_producto' => $validatedData['ctrt_producto'],
            'ctrt_precio' => $validatedData['ctrt_precio'],
            'ctrt_precio_html' => $validatedData['ctrt_precio_html'],
            'ctrt_medida' => $validatedData['ctrt_medida'],
            'ctrt_terminos_envio' => $validatedData['ctrt_terminos_envio'],
            'ctrt_embarque' => $validatedData['ctrt_embarque'],
            'ctrt_empaque' => $validatedData['ctrt_empaque'],
            'selectedAnalisis' => $validatedData['selectedAnalisis'] ?? [],
            'ctrt_pago' => $validatedData['ctrt_pago'],
            'ctrt_pago_html' => $validatedData['ctrt_pago_html'],
            'ctrt_cantidad' => $validatedData['ctrt_cantidad'],
            'ctrt_por_anticipo' => $validatedData['ctrt_por_anticipo'],
            'ctrt_por_pago' => $validatedData['ctrt_por_pago'],
            'ctrt_terminos' => $validatedData['ctrt_terminos'],
            'ctrt_doc_vendedor' => $validatedData['ctrt_doc_vendedor'],
            'ctrt_doc_comprador' => $validatedData['ctrt_doc_comprador'],
            'ctrt_adicional_etiqueta' => $validatedData['ctrt_adicional_etiqueta'] ?? [],
            'ctrt_adicional_contenido' => $validatedData['ctrt_adicional_contenido']?? [],
        ];

        $contrato = new Contrato();
        $contrato->ctrt_fecha = $validatedData['ctrt_fecha_contrato'];
        $contrato->ctrt_contenido = json_encode($contenido);
        $contrato->save();

        return redirect()->route('contratos.index');
    }

    public function show($id)//uso
    {
        $contrato = Contrato::find($id);
        return Inertia::render('Contratos/Show', [
            'contrato' => $contrato,
        ]);
    }

    public function edit($id)//uso
    {
        $contrato = Contrato::find($id);
        return Inertia::render('Contratos/Edit', [
            'contrato' => $contrato,
        ]);
    }

    public function update(ContratoRequest $request)//uso
    {
        $validatedData = $request->validated();
        $contrato = Contrato::findOrFail($request->id);

        $contenido = [
            'ctrt_vendedor' => $validatedData['ctrt_vendedor'],
            'ctrt_comprador' => $validatedData['ctrt_comprador'],
            'ctrt_direccion_comprador' => $validatedData['ctrt_direccion_comprador'],
            'ctrt_producto' => $validatedData['ctrt_producto'],
            'ctrt_precio' => $validatedData['ctrt_precio'],
            'ctrt_precio_html' => $validatedData['ctrt_precio_html'],
            'ctrt_medida' => $validatedData['ctrt_medida'],
            'ctrt_terminos_envio' => $validatedData['ctrt_terminos_envio'],
            'ctrt_embarque' => $validatedData['ctrt_embarque'],
            'ctrt_empaque' => $validatedData['ctrt_empaque'],
            'selectedAnalisis' => $validatedData['selectedAnalisis'] ?? [],
            'ctrt_pago' => $validatedData['ctrt_pago'],
            'ctrt_pago_html' => $validatedData['ctrt_pago_html'],
            'ctrt_cantidad' => $validatedData['ctrt_cantidad'],
            'ctrt_por_anticipo' => $validatedData['ctrt_por_anticipo'],
            'ctrt_por_pago' => $validatedData['ctrt_por_pago'],
            'ctrt_terminos' => $validatedData['ctrt_terminos'],
            'ctrt_doc_vendedor' => $validatedData['ctrt_doc_vendedor'],
            'ctrt_doc_comprador' => $validatedData['ctrt_doc_comprador'],
            'ctrt_adicional_etiqueta' => $validatedData['ctrt_adicional_etiqueta'] ?? [],
            'ctrt_adicional_contenido' => $validatedData['ctrt_adicional_contenido']?? [],
        ];

        $contrato->ctrt_fecha = $validatedData['ctrt_fecha_contrato'];
        $contrato->ctrt_contenido = json_encode($contenido);
        $contrato->save();

        if ($request->input('status') == 1) {
            $codigo = Contrato::generarCodigoContrato($request);
            $contrato->ctrt_codigo = $codigo;
            $contrato->ctrt_estado = $request->input('status');
            $contrato->save();
        }

        return redirect()->route('contratos.index');
    }

    public function upload(Request $request)//uso
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'contrato_id' => 'required|integer',
        ]);

        try {
            $file = $request->file('file');
            $contratoId = $request->input('contrato_id');

            $uniqueFileName = "contrato_{$contratoId}_" . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/contratos', $uniqueFileName);

            $contrato = Contrato::find($contratoId);
            $contrato->pdf_contrato = $uniqueFileName;
            $contrato->save();

            return response()->json([
                'path' => $uniqueFileName,
                'file_name' => $uniqueFileName
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function pdf($conocimientoId)//uso
    {
        $contrato = Contrato::find($conocimientoId);
        $contenido = json_decode($contrato->ctrt_contenido, true);

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');

        $pdf = $pdf->loadView('contrato', compact('contrato', 'contenido'));
        return $pdf->stream('contrato.pdf');
    }


}
