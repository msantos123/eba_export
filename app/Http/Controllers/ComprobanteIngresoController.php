<?php

namespace App\Http\Controllers;

use App\Models\ComprobanteIngreso;
use App\Models\Conocimiento;
use App\Models\Carga;
use App\Models\Planta;
use App\Models\Solicitudcarga;
use App\Models\User;
use App\Models\Inventarios;

use App\Http\Requests\ComprobanteIngresoRequest;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComprobanteIngresoController extends Controller
{
    public function index()//uso
    {
        $comprobanteIngreso = ComprobanteIngreso::indexIngreso();
        return Inertia::render('ComprobanteIngreso/Index', [
            'comprobanteIngreso' => $comprobanteIngreso,
        ]);
    }

    public function createAlmacen($id)//uso
    {
        $codigo = ComprobanteIngreso::generarCodigoIngreso($id);
        $conocimiento = Conocimiento::where('id',$id)->first();
        $cargas =  Carga::where('solicitud_cargas', $conocimiento->solicitud_id)->get();
        $solicitud = Solicitudcarga::verSolicitudcarga($conocimiento->solicitud_id);

        return Inertia::render('ComprobanteIngreso/Create', [
            'conocimiento' => $conocimiento,
            'cargas' => $cargas,
            'codigo' => $codigo,
            'solicitud' => $solicitud,
        ]);
    }

    public function store(ComprobanteIngresoRequest $request)//uso
    {
        try {
            $conocimiento = Conocimiento::findOrFail($request->conocimiento_id);
            $conocimiento->estado = 2;
            $conocimiento->save();

            ComprobanteIngreso::crearIngreso($request);

            // Retornar una respuesta JSON de éxito
            return response()->json(['message' => 'Ingreso guardado exitosamente'], 200);
        } catch (\Exception $e) {
            // Manejo de errores en caso de excepción
            return response()->json(['message' => 'Ocurrió un error al guardar el ingreso.'], 500);
        }
    }

    public function edit($id)//uso
    {
        $comprobanteIngreso = ComprobanteIngreso::where('id',$id)->first();
        $conocimientoId = $comprobanteIngreso->conocimiento_id;
        $conocimiento = Conocimiento::where('id',$conocimientoId)->first();
        $solicitudId = $conocimiento->solicitud_id;
        $cargas = Carga::where('solicitud_cargas', $solicitudId)->get();
        $solicitud = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.planta_id',
        'plantas.planta_id as plantas_id','plantas.nombre as plantas_nombre')
            ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
            ->where('solicitudcargas.id',$solicitudId)->first();

        return Inertia::render('ComprobanteIngreso/Edit', [
            'conocimiento' => $conocimiento,
            'cargas' => $cargas,
            'solicitud' => $solicitud,
            'comprobateIngreso' => $comprobanteIngreso,
        ]);
    }

    public function pdf($id)//uso
    {
        $comprobanteIngreso = ComprobanteIngreso::pdfIngreso($id);
        $cargas =  Carga::where('solicitud_cargas', $comprobanteIngreso->solicitud_id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');
        $pdf = $pdf->loadView('comprobante-ingreso', compact('comprobanteIngreso','cargas'));
        return $pdf->stream('ComprobanteIngreso.pdf');
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

            // Crear un nombre único para el archivo usando el ID de conocimiento
            $uniqueFileName = "comprobante_ingreso_{$comprobanteId}_" . Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Guardar el archivo en el storage
            $path = $file->storeAs('public/comprobante_ingreso', $uniqueFileName);

            // Guardar el nombre del archivo en la base de datos
            $comprobanteIngreso = ComprobanteIngreso::find($comprobanteId);
            $comprobanteIngreso->pdf_comprobante_ingreso = $uniqueFileName;
            $comprobanteIngreso->save();

            // Retornar la respuesta con la ruta y el nombre del archivo
            return response()->json([
                'path' => $uniqueFileName,
                'file_name' => $uniqueFileName
            ], 200);
        } catch (\Exception $e) {
            // Manejar cualquier excepción y retornar un error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
