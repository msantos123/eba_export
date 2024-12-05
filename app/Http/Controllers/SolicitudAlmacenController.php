<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAlmacen;
use App\Models\Solicitudcarga;
use App\Models\Planta;
use App\Models\Kardex;
use App\Models\Carga;
use App\Http\Controllers\SolicitudcargaController;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SolicitudAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//uso
    {
        $solicitudAlmacen = Solicitudcarga::indexSolicitudCargaAlmacen();
        $plantas = Planta::all();

        return Inertia::render('SolicitudAlmacen/Index',[
            'solicitudAlmacen'=>$solicitudAlmacen,
            'plantas'=>$plantas,
        ]);
    }

    public function create($planta_id)//uso
    {
        $inventarioAlmacenes = Kardex::productoKardex($planta_id);
        $planta = Planta::where('planta_id',$planta_id)->first();

        return Inertia::render('SolicitudAlmacen/Create',[
            'inventarioAlmacenes'=>$inventarioAlmacenes,
            'planta' => $planta,
        ]);
    }

    public function store(Request $request)//uso
    {
        $request->merge(['usuario_id' => auth()->id()]);
        Solicitudcarga::crearSolicitudcargaAlmacen($request->all());
        return response()->json(['message' => 'Solicitud enviada exitosamente.'], 200);
    }

    public function pdfFechasElaboracion($id)
    {
        $solicitudcarga = Solicitudcarga::find($id);
        $cargas = SolicitudAlmacen::fechaElaboracion($id);

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');
        $pdf = $pdf->loadView('fechas-elaboracion', compact('solicitudcarga','cargas'));

        return $pdf->stream('fecha_elaboracion.pdf');
    }

    public function show($id)//uso
    {
        $solicitudcarga = Solicitudcarga::verSolicitudcarga($id);
        $cargas = Carga::where('solicitud_cargas',$id)->get();
        return Inertia::render('SolicitudAlmacen/Show', [
            'cargas' => $cargas,
            'solicitudcarga' => $solicitudcarga,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //dd($id);
        $solicitudcarga = Solicitudcarga::where('id',$id)->get();
        //dd($solicitudcarga);
        $cargas = Carga::where('solicitud_cargas',$id)->get();
        return Inertia::render('SolicitudAlmacen/Edit', [
            'cargas' => $cargas,
            'solicitudcarga' => $solicitudcarga,
        ]);
    }
}
