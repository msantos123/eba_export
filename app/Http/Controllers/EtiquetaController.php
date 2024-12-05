<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComprobanteSalida;
use App\Models\Etiqueta;
use App\Models\SigaSalidaDetalle;
use Inertia\Inertia;
use Dompdf\Dompdf;
use Dompdf\Options;

class EtiquetaController extends Controller
{
    public function index()//uso
    {
        $comprobanteSalida = Etiqueta::etiquetasIndex();
        return Inertia::render('Etiquetas/Index', [
            'comprobanteSalida' => $comprobanteSalida,
        ]);
    }

    public function cargasEtiqueta(Request $request)//uso
    {
        $salidas = $request->input('salidas');
        $detallesGuardados = [];

        foreach ($salidas as $salidaId) {
            $listaDetalle = SigaSalidaDetalle::select('siga_salida_detalles.*',
            'siga.insumo_receta.rece_nombre as rece_nombre')
            ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','siga_salida_detalles.rece_id')
            ->where('cargaSalida_id', $salidaId)
            ->get();

            foreach ($listaDetalle as $detalle) {

                $detallesGuardados[] = $detalle;
            }
        }
        return Inertia::render('Etiquetas/Show', [
            'detallesGuardados' => $detallesGuardados,
        ]);
    }

    public function verEtiquetas ()//uso
    {
        $etiquetas = Etiqueta::all();
        return response()->json($etiquetas);
    }

    public function etiquetasPdf(Request $request)//uso
    {
        $content = $request->content;
        $detallesGuardados = $request->detallesGuardados;

        $etiquetas = [];
        foreach ($detallesGuardados as $detalle) {

            $cantidadSalida = $detalle['cantidad_salida'] ?? 1;

            for ($i = 0; $i < $cantidadSalida; $i++) {
                $etiquetas[] = [
                    'lote' => $detalle['lote_detalle'] ?? 'No disponible',
                    'fecha_envasado' => $detalle['fecha_envasado'] ?? 'No disponible',
                ];
            }
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');
        $pdf->loadView('etiquetas-generadas', [
            'content' => $content,
            'etiquetas' => $etiquetas,
        ]);
        $pdf->setOptions([
            'margin-top' => 0,
            'margin-left' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
        ]);

        return $pdf->stream('etiquetas-generadas.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="document.pdf"',
        ]);
    }

    public function etiquetasChina(Request $request)//uso
    {
        $detallesGuardados = $request->detallesGuardados;
        // Crear un array para las etiquetas
        $etiquetas = [];
        foreach ($detallesGuardados as $detalle) {

            $cantidadSalida = $detalle['cantidad_salida'] ?? 1;

            $fecha = $detalle['fecha_envasado'];
            $partes = explode('-', $fecha);

            $anoEnvasado = $partes[0];
            $mesEnvasado = $partes[1];
            $diaEnvasado = $partes[2];

            $fecha = $detalle['fecha_vencimiento'];
            $date = new \DateTime($fecha);
            $date->modify('-1 day');
            $nueva_fecha = $date->format('Y-m-d');

            $partes = explode('-', $nueva_fecha);

            $anoVencimiento = $partes[0];
            $mesVencimiento = $partes[1];
            $diaVencimiento = $partes[2];

            switch ($detalle['rece_id']) {
                case 347: $tipo = 'Medium'; break;
                case 348: $tipo = 'Midget'; break;
                case 349: $tipo = 'Chipped'; break;
                case 350: $tipo = 'Broken'; break;
                case 351: $tipo = 'Broken D'; break;
                case 352: $tipo = 'Tinny'; break;

                default: $tipo = 'Ninguno'; break;
            }

            for ($i = 0; $i < $cantidadSalida; $i++) {
                if($detallesGuardados )
                $etiquetas[] = [
                    'tipo' => $tipo ?? 'Ninguno',
                    'lote' => $detalle['lote_detalle'] ?? 'No disponible',

                    'anoEnvasado' => $anoEnvasado ?? 'Ninguno',
                    'mesEnvasado' => $mesEnvasado ?? 'Ninguno',
                    'diaEnvasado' => $diaEnvasado ?? 'Ninguno',

                    'anoVencimiento' => $anoVencimiento ?? 'Ninguno',
                    'mesVencimiento' => $mesVencimiento ?? 'Ninguno',
                    'diaVencimiento' => $diaVencimiento ?? 'Ninguno',

                ];
            }
        }

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('Folio');
        //$pdf->setPaper('Folio', 'landscape');
        $pdf->loadView('etiquetas-china', [
            'etiquetas' => $etiquetas,
        ]);
        $pdf->setOptions([
            'margin-top' => 0,
            'margin-left' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
        ]);

        return $pdf->stream('etiquetas-china.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="document.pdf"',
        ]);
    }

    public function guardarEtiqueta (Request $request)//uso
    {
        $request->merge(['usuario_id' => auth()->id()]);
        $request->validate([
            'nombreEtiqueta' => 'required|string|max:255',
            'saveContent' => 'required|string',
            'usuario_id' => 'required',
        ]);

        Etiqueta::create([
            'eti_usuario' => 5136,
            'eti_nombre' => $request->input('nombreEtiqueta'),
            'eti_contenido' => $request->input('saveContent'),
        ]);

        return response()->json(['message' => 'Etiqueta guardada correctamente']);
    }

    public function eliminarEtiqueta($id)//uso
    {
        $etiqueta = Etiqueta::find($id);

        if (!$etiqueta) {
            return response()->json(['message' => 'Etiqueta no encontrada'], 404);
        }

        $etiqueta->delete();
        return response()->json(['message' => 'Etiqueta eliminada correctamente']);
    }
}
