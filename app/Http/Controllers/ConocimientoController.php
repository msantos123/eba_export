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
//request
use App\Http\Requests\ConocimientoRequest;
//complementos
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConocimientoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $conocimiento = Conocimiento::select('conocimientos.id','conocimientos.codigo',
        'empresa','conductor','vehiculo','placa','celular','conocimientos.estado',
        'solicitudcargas.planta_id as planta','plantas.nombre as plantaNombre')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->orderBy('conocimientos.codigo', 'desc');

        if($user->planta_id != 1 && $user->planta_id != 2)
        {
            $conocimiento->whereIn('solicitudcargas.planta_id',[$user->planta_id]);
        }

        $conocimiento = $conocimiento->get();

        return Inertia::render('Conocimientos/Index',['conocimientos'=>$conocimiento]);
    }

    public function create()
    {

    }

    public function store(ConocimientoRequest $request)
    {
        //dd($request);
        $solicitudcarga = SolicitudCarga::find($request->input('solicitud_id'));
        $solicitudcarga->estado = 3;
        $solicitudcarga->save();

        $request->merge(['usuario_id' => auth()->id()]);
        $conocimiento = Conocimiento::create([
            'usuario_id' => $request->input('usuario_id'),
            'empresa' => $request->input('empresa'),
            'conductor' => $request->input('conductor'),
            'vehiculo' => $request->input('vehiculo'),
            'propietario' => $request->input('propietario'),
            'licencia' => $request->input('licencia'),
            'placa' => $request->input('placa'),
            'celular' => $request->input('celular'),
            'solicitud_id' => $request->input('solicitud_id'),
        ]);

        return redirect('conocimientos');
    }

    public function show($id)
    {
        $conocimientos = Conocimiento::where('id',$id)->first();
        $solicitudId = $conocimientos->solicitud_id;
        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo',
        'solicitudcargas.usuario_id','solicitudcargas.planta_id','solicitudcargas.created_at','solicitudcargas.estado',
        'users.name as nombre','users.paterno as paterno','users.materno as materno','plantas.nombre as planta_nombre')
        ->join('users','users.id','=','solicitudcargas.usuario_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->where('solicitudcargas.id',$solicitudId)->first();
        $solicitudId = $solicitudcarga->id;
        $cargas = Carga::where('solicitud_cargas', $solicitudId)->get();

        return Inertia::render('Conocimientos/Show', [
            'cargas' => $cargas,
            'solicitudcarga' => $solicitudcarga,
            'conocimientos' => $conocimientos,
        ]);
    }

    public function edit($id)
    {
        $conocimientos = Conocimiento::where('id',$id)->first();

        $cargas =  Carga::where('solicitud_cargas', $conocimientos->solicitud_id)->get();

        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo',
        'solicitudcargas.usuario_id','solicitudcargas.planta_id','solicitudcargas.created_at','solicitudcargas.estado',
        'users.name as nombre','users.paterno as paterno','users.materno as materno','plantas.nombre as planta_nombre')
        ->join('users','users.id','=','solicitudcargas.usuario_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->where('solicitudcargas.id',$conocimientos->solicitud_id)->first();


        return Inertia::render('Conocimientos/Edit', [
            'conocimientos' => $conocimientos,
            'solicitudcarga' => $solicitudcarga,
            'cargas' => $cargas,
        ]);
    }

    public function update(ConocimientoRequest $request, Conocimiento $conocimiento)
    {
        $conocimiento->update($request->all());

        if ($request->input('status') == 1) {
            $codigo = Conocimiento::generarCodigoConocimiento($request);
            $conocimiento->codigo = $codigo;
            $conocimiento->estado = $request->input('status');
            $conocimiento->save();
        }

        return redirect('conocimientos');
    }

    public function pdf($conocimientoId)
    {
        $conocimientos = Conocimiento::select('conocimientos.id','conocimientos.codigo',
        'conocimientos.usuario_id as usuario_planta','empresa','conductor','vehiculo',
        'propietario','licencia','placa','conocimientos.celular','conocimientos.estado',
        'plantas.nombre as planta','users.paterno as paterno','users.materno as materno',
        'users.name as nombre','conocimientos.solicitud_id',
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->join('cargas', 'cargas.solicitud_cargas', '=', 'solicitudcargas.id')
        ->join('users', 'users.id','=','conocimientos.usuario_id')
        ->groupBy('conocimientos.id', 'conocimientos.codigo', 'conocimientos.usuario_id',
                'empresa', 'conductor', 'vehiculo', 'propietario', 'licencia', 'placa',
                'conocimientos.celular', 'conocimientos.estado', 'plantas.nombre', 'users.paterno',
                'users.materno', 'users.name', 'conocimientos.solicitud_id')
        ->where('conocimientos.id', $conocimientoId)->first();

        $almacen = User::where('planta_id',2)->first();

        $cargas =  Carga::where('solicitud_cargas', $conocimientos->solicitud_id)->get();

        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('letter');
        $pdf = $pdf->loadView('conocimiento', compact('conocimientos','cargas','almacen'));
        return $pdf->stream('conocimientodecarga.pdf');
    }

    public function CrearConocimiento($id)
    {
        $cargas =  Carga::where('solicitud_cargas', $id)->get();

        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo',
        'solicitudcargas.usuario_id','solicitudcargas.planta_id','solicitudcargas.created_at','solicitudcargas.estado',
        'users.name as nombre','users.paterno as paterno','users.materno as materno','plantas.nombre as planta_nombre')
        ->join('users','users.id','=','solicitudcargas.usuario_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->where('solicitudcargas.id',$id)->first();

        $conocimientos = Conocimiento::all();

        return Inertia::render('Conocimientos/Create', [
            'conocimientos' => $conocimientos,
            'solicitudcarga' => $solicitudcarga,
            'cargas' => $cargas,
        ]);
    }

}
