<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
//modelos
use App\Models\Planta;
use App\Models\Carga;
use App\Models\User;
use App\Models\Conocimiento;
use App\Models\Department;
use App\Models\Solicitudcarga;
use App\Models\SigaSalidaDetalle;
//request
use App\Http\Requests\ConocimientoRequest;
//complementos
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ConocimientoController extends Controller
{
    public function index()//uso
    {
        $conocimiento = Conocimiento::indexConocimiento();
        return Inertia::render('Conocimientos/Index',[
            'conocimientos'=>$conocimiento
        ]);
    }

    public function create($id)//uso
    {
        $cargas =  Carga::where('solicitud_cargas', $id)->get();
        $solicitudcarga = Solicitudcarga::verSolicitudcarga($id);
        $conocimientos = Conocimiento::all();

        return Inertia::render('Conocimientos/Create', [
            'conocimientos'     => $conocimientos,
            'solicitudcarga'    => $solicitudcarga,
            'cargas'            => $cargas,
        ]);
    }

    public function store(ConocimientoRequest $request)//uso
    {
        $solicitudcarga = SolicitudCarga::find($request->input('solicitud_id'));
        $solicitudcarga->estado = 2;
        $solicitudcarga->save();

        $request->merge(['usuario_id' => auth()->id()]);
        $conocimiento = Conocimiento::guardarConocimiento($request);

        return response()->json('Guardado exitosamente');
    }

    public function show($id)//uso
    {
        $conocimientos = Conocimiento::where('id',$id)->first();
        $solicitudcarga = Solicitudcarga::verSolicitudcarga($conocimientos->solicitud_id);
        $cargas = Carga::where('solicitud_cargas', $solicitudcarga->id)->get();
        $salidaDetalle = SigaSalidaDetalle::verSigaSalidaDetalle($solicitudcarga->salida_inventario);

        return Inertia::render('Conocimientos/Show', [
            'cargas' => $cargas,
            'solicitudcarga' => $solicitudcarga,
            'conocimientos' => $conocimientos,
            'salidaDetalle'     => $salidaDetalle,
        ]);
    }

    public function edit($id)//uso
    {
        $conocimientos = Conocimiento::where('id',$id)->first();
        $cargas =  Carga::where('solicitud_cargas', $conocimientos->solicitud_id)->get();
        $solicitudcarga = Solicitudcarga::verSolicitudcarga($conocimientos->solicitud_id);

        return Inertia::render('Conocimientos/Edit', [
            'conocimientos' => $conocimientos,
            'solicitudcarga' => $solicitudcarga,
            'cargas' => $cargas,
        ]);
    }

    public function update(ConocimientoRequest $request)//uso
    {
        $conocimiento = Conocimiento::where('id',$request->id)->first();
        $conocimiento->update($request->all());

        if ($request->input('status') == 1) {
            $codigo = Conocimiento::generarCodigoConocimiento($request);
            //Log::debug('Código generado para depuración:', ['codigo' => $codigo]);
            $conocimiento->codigo = $codigo;
            $conocimiento->estado = $request->input('status');
            $conocimiento->save();
        }

        return response()->json('Actualizado exitosamente');
    }

    public function pdf($conocimientoId)//uso
    {
        $conocimientos = Conocimiento::pdfConocimiento($conocimientoId);
        $cargas =  Carga::where('solicitud_cargas', $conocimientos->solicitud_id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');

        if($conocimientos->estado == 1)
        { $pdf = $pdf->loadView('conocimiento', compact('conocimientos','cargas'));
        }else{
            $pdf = $pdf->loadView('conocimiento_borrador', compact('conocimientos','cargas'));
        }
        return $pdf->stream('conocimientodecarga.pdf');
    }

    public function upload(Request $request)//uso
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'conocimiento_id' => 'required|integer',
        ]);

        try {
            $file = $request->file('file');
            $conocimientoId = $request->input('conocimiento_id');

            // Crear un nombre único para el archivo usando el ID de conocimiento
            $uniqueFileName = "conocimiento_{$conocimientoId}_" . Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Guardar el archivo en el storage
            $path = $file->storeAs('public/conocimientos', $uniqueFileName);

            // Guardar el nombre del archivo en la base de datos
            $conocimiento = Conocimiento::find($conocimientoId);
            $conocimiento->pdf_conocimiento = $uniqueFileName;
            $conocimiento->save();

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
