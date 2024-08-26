<?php

namespace App\Http\Controllers;

use App\Models\ComprobanteIngreso;
use App\Models\Conocimiento;
use App\Models\Carga;
use App\Models\Planta;
use App\Models\Solicitudcarga;
use App\Models\User;
use App\Models\Inventarios;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComprobanteIngresoController extends Controller
{
    public function index()
    {
        $comprobanteIngreso = ComprobanteIngreso::select('comprobante_ingresos.*','plantas.nombre as plantas_nombre',
        'conocimientos.codigo')
        ->join('conocimientos','conocimientos.id','=','comprobante_ingresos.conocimiento_id')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->with('vercargas')
        ->get();

        //dd($comprobanteIngreso);

        return Inertia::render('ComprobanteIngreso/Index', [
            'comprobanteIngreso' => $comprobanteIngreso,
        ]);
    }

    public function store(Request $request)
    {
        $comprobanteIngreso = ComprobanteIngreso::create([
            'codigo_ingreso' => $request->input('codigo_ingreso'),
            'fecha_ingreso' => $request->input('fecha_ingreso'),
            'cefo' => $request->input('cefo'),
            'observaciones' => $request->input('observaciones'),
            'conocimiento_id' => $request->input('conocimiento_id'),
        ]);
        return redirect('comprobante_ingreso');
    }

    public function show($id)
    {
        //dd($id);
        $conocimiento = Conocimiento::where('id',$id)->first();
        $solicitudId = $conocimiento->solicitud_id;

        $cargas = Carga::where('solicitud_cargas', $solicitudId)->get();
        $solicitud = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.planta_id',
        'plantas.id as plantas_id','plantas.nombre as plantas_nombre')
            ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
            ->where('solicitudcargas.id',$solicitudId)->first();

        $codigo = ComprobanteIngreso::generarCodigoIngreso($id);

        return Inertia::render('ComprobanteIngreso/Create', [
            'conocimiento' => $conocimiento,
            'cargas' => $cargas,
            'codigo' => $codigo,
            'solicitud' => $solicitud,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComprobanteIngreso $comprobanteIngreso)
    {
        $conocimientoId = $comprobanteIngreso->conocimiento_id;
        $conocimiento = Conocimiento::where('id',$conocimientoId)->first();
        $solicitudId = $conocimiento->solicitud_id;
        $cargas = Carga::where('solicitud_cargas', $solicitudId)->get();
        $solicitud = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.planta_id',
        'plantas.id as plantas_id','plantas.nombre as plantas_nombre')
            ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
            ->where('solicitudcargas.id',$solicitudId)->first();

        return Inertia::render('ComprobanteIngreso/Edit', [
            'conocimiento' => $conocimiento,
            'cargas' => $cargas,
            'solicitud' => $solicitud,
            'comprobateIngreso' => $comprobanteIngreso,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComprobanteIngreso $comprobanteIngreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComprobanteIngreso $comprobanteIngreso)
    {
        //
    }

    public function pdf($id)
    {
        $comprobanteIngreso = ComprobanteIngreso::select('comprobante_ingresos.id','fecha_ingreso','codigo_ingreso',
        'cefo','observaciones','conocimientos.codigo',
        'conocimientos.usuario_id as usuario_planta','conocimientos.empresa','conocimientos.conductor',
        'conocimientos.vehiculo','conocimientos.propietario','conocimientos.licencia','conocimientos.placa',
        'conocimientos.celular','conocimientos.estado',
        'plantas.nombre as planta','users.paterno as paterno','users.materno as materno',
        'users.name as nombre','conocimientos.solicitud_id',
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('conocimientos','conocimientos.id','=','comprobante_ingresos.conocimiento_id')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->join('cargas', 'cargas.solicitud_cargas', '=', 'solicitudcargas.id')
        ->join('users', 'users.id','=','conocimientos.usuario_id')
        ->groupBy('comprobante_ingresos.id','comprobante_ingresos.fecha_ingreso','comprobante_ingresos.codigo_ingreso',
                'comprobante_ingresos.cefo','comprobante_ingresos.observaciones','conocimientos.codigo','conocimientos.usuario_id',
                'conocimientos.empresa','conocimientos.conductor','conocimientos.vehiculo','conocimientos.propietario',
                'conocimientos.licencia','conocimientos.placa','conocimientos.celular', 'conocimientos.estado', 'plantas.nombre',
                'users.paterno','users.materno', 'users.name', 'conocimientos.solicitud_id')
        ->where('comprobante_ingresos.id', $id)->first();

        $almacen = User::where('planta_id',2)->first();
        $cargas =  Carga::where('solicitud_cargas', $comprobanteIngreso->solicitud_id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');
        $pdf = $pdf->loadView('comprobante-ingreso', compact('comprobanteIngreso','cargas','almacen'));
        return $pdf->stream('ComprobanteIngreso.pdf');
    }

    public function IngresarAlmacen($id)
    {
        $codigo = ComprobanteIngreso::generarCodigoIngreso($id);
        $conocimiento = Conocimiento::findOrFail($id);
        $conocimiento->estado = 2;
        $conocimiento->save();

        $conocimiento = Conocimiento::where('id',$id)->first();
        $cargas =  Carga::where('solicitud_cargas', $conocimiento->solicitud_id)->get();
        $solicitud = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.planta_id',
        'plantas.id as plantas_id','plantas.nombre as plantas_nombre')
            ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
            ->where('solicitudcargas.id',$conocimiento->solicitud_id)->first();

        return Inertia::render('ComprobanteIngreso/Create', [
            'conocimiento' => $conocimiento,
            'cargas' => $cargas,
            'codigo' => $codigo,
            'solicitud' => $solicitud,
        ]);
    }
}
