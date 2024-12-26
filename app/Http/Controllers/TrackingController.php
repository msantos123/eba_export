<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ComprobanteSalida;
use App\Models\Tracking;
use App\Models\Liberacion;
use App\Http\Requests\LiberacionRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function index()//uso
    {
        $comprobanteSalidas = ComprobanteSalida::orderBy('fecha_salida', 'desc') // Primer ordenamiento
        ->orderBy('factura', 'asc')
        ->get();
        return Inertia::render('Tracking/Index', [
            'comprobanteSalidas' => $comprobanteSalidas,
        ]);
    }

    public function show($id)//uso
    {
        $comprobanteSalida = ComprobanteSalida::find($id);
        return Inertia::render('Tracking/Show', [
            'comprobanteSalida' => $comprobanteSalida,
        ]);
    }

    public function liberacion(LiberacionRequest $request)//uso
    {
        try {
            $archivosSubidos = [];
            $nrosDocumentos = $request->input('nros');

            foreach ($request->file('documentos') as $index => $documento) {
                $nroDocumento = $nrosDocumentos[$index]; // Obtener el número de documento correspondiente

                // Crear un nombre único para el archivo
                $uniqueFileName = "documento_{$nroDocumento}_" . Str::uuid() . '.' . $documento->getClientOriginalExtension();

                // Guardar el archivo en el storage
                $documento->storeAs('public/liberaciones', $uniqueFileName);

                $documentosData[] = [
                    'nro_documento' => $nroDocumento,
                    'pdf_documento' => $uniqueFileName,
                ];
            }
                // Guardar el nombre del archivo en la base de datos
                $liberacion = new Liberacion();
                $liberacion->libe_usu = Auth::id();
                $liberacion->libe_nave_viaje = $request->input('libe_nave_viaje');
                $liberacion->libe_bl = $request->input('libe_bl');
                $liberacion->libe_puerto = $request->input('libe_puerto');
                $liberacion->libe_consignatario = $request->input('libe_consignatario');
                $liberacion->libe_direccion = $request->input('libe_direccion');
                $liberacion->libe_factura = $request->input('factura'); // Ajusta según tu lógica
                $liberacion->documentos = json_encode($documentosData); // Almacenar todos los documentos como JSON
                $liberacion->save();
                // Actualizar el comprobante de salida
                $comprobanteSalida = ComprobanteSalida::where('factura', $request->input('factura'))->first();
                if ($comprobanteSalida) {
                    $comprobanteSalida->liberacion = 1; // Cambiar el estado de 0 a 1
                    $comprobanteSalida->save();
                }


                return response()->json([
                    'message' => 'Archivos subidos exitosamente.',
                    'documentos' => $documentosData, // Devolver la información de los documentos
                ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
