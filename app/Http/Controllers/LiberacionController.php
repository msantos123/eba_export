<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Liberacion;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LiberacionController extends Controller
{
    public function index()//uso
    {
        $liberaciones = Liberacion::all();
        return Inertia::render('Liberacion/Index', [
            'liberaciones' => $liberaciones,
        ]);
    }

    public function show($id)//uso
    {
        $liberacion = Liberacion::where('liberaciones.id', $id)->first();
        return Inertia:: render('Liberacion/Show', [
            'liberacion' => $liberacion,
        ]);
    }

    public function aprobacion($estado, $id)//uso
    {
        $liberacion = Liberacion::where('id', $id)->first();
        $liberacion->libe_estado = $estado;
        $liberacion->save();
        return redirect('liberacion/index');
    }

    public function pdf($id)//uso
    {
        $liberacion = Liberacion::select('_bp_usuarios.usr_usuario as usuario','liberaciones.*')
        ->join('public._bp_usuarios','public._bp_usuarios.usr_id','=','liberaciones.libe_usu')
        ->where('liberaciones.id', $id)
        ->first();
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');
        $pdf = $pdf->loadView('carta_liberacion', compact('liberacion'));
        return $pdf->stream('CartaLiberacion.pdf');
    }

    public function upload(Request $request)//uso
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'liberacion_id' => 'required|integer',
            'document_type' => 'required|string',
        ]);

        try {
            $file = $request->file('file');
            $liberacionId = $request->input('liberacion_id');
            $documentType = $request->input('document_type');

            // Crear un nombre único para el archivo usando el ID de conocimiento
            $uniqueFileName = "liberacion_{$liberacionId}_" . Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Guardar el archivo en el storage
            $path = $file->storeAs('public/liberaciones', $uniqueFileName);

            // Guardar el nombre del archivo en la base de datos
            $liberacion = Liberacion::find($liberacionId);
            if ($documentType === 'carta') {
                $liberacion->pdf_cartaliberacion = $uniqueFileName;
            } elseif ($documentType === 'seaway') {
                $liberacion->pdf_seawaybill = $uniqueFileName;
            }
            $liberacion->save();

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
