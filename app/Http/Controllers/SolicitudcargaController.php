<?php

namespace App\Http\Controllers;
//modelos
use App\Models\Planta;
use App\Models\Producto;
use App\Models\Carga;
use App\Models\User;
use App\Models\Solicitudcarga;
use App\Models\Kardex;
//request
use App\Http\Requests\SolicitudcargaRequest;
//otros
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SolicitudcargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo',
        'solicitudcargas.estado','users.name as usuario','plantas.nombre as planta',
        DB::raw('DATE(solicitudcargas.created_at) as fecha'),
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('users', 'users.id','=','solicitudcargas.usuario_id')
        ->join('plantas', 'plantas.id','=','solicitudcargas.planta_id')
        ->join('cargas', 'cargas.solicitud_cargas', '=', 'solicitudcargas.id')
        ->groupBy('solicitudcargas.id','solicitudcargas.created_at','solicitudcargas.codigo',
        'solicitudcargas.estado', 'users.name', 'plantas.nombre');

        if ($user->planta_id != 1)
        {
            $solicitudcarga->whereIn('solicitudcargas.planta_id', [$user->planta_id]);
        }
        $solicitudcarga = $solicitudcarga->get();
        //dd($solicitudcarga);

        return Inertia::render('Cargas/Index',['solicitudcarga'=>$solicitudcarga]);
    }

    public function create()
    {
        $plantas = Planta::where('tipo','Planta')->where('estado',1)->get();

        $productos = Producto::all();
        return Inertia::render('Cargas/Create',['plantas'=>$plantas, 'productos'=>$productos]);
    }

    public function store(Request $request)
    {
        $request->merge(['usuario_id' => auth()->id()]);
        $solicitudcarga = Solicitudcarga::create([
            'planta_id' => $request->input('planta_id'),
            'usuario_id' => $request->input('usuario_id'),
            'estado' => $request->status,
        ]);
        foreach ($request->input('carga') as $detail) {
            $carga = Carga::create([
                'codigo_producto'   =>      $detail[0],
                'nombre_producto'   =>      $detail[1],
                'descripcion'       =>      $detail[2],
                'cantidad'          =>      $detail[3],
                'kilosnetos'        =>      $detail[4],
                'librasnetas'       =>      $detail[5],
                'solicitud_cargas'  =>      $solicitudcarga->id,

            ]);
        }
        return redirect('solicitudcargas');
    }

    public function show(Solicitudcarga $solicitudcarga)
    {
        $solicitudId = $solicitudcarga->id;
        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo',
        'solicitudcargas.usuario_id','solicitudcargas.planta_id','solicitudcargas.created_at','solicitudcargas.estado',
        'users.name as nombre','users.paterno as paterno','users.materno as materno','plantas.nombre as planta_nombre')
        ->join('users','users.id','=','solicitudcargas.usuario_id')
        ->join('plantas','plantas.id','=','solicitudcargas.planta_id')
        ->where('solicitudcargas.id',$solicitudId)->first();
        $cargas = Carga::where('solicitud_cargas',$solicitudId)->get();

        return Inertia::render('Cargas/Show', [
            'cargas' => $cargas,
            'solicitudcarga' => $solicitudcarga,
        ]);

    }

    public function edit(Solicitudcarga $solicitudcarga)
    {
        //dd($solicitudcarga);
        $solicitudcargaId = $solicitudcarga->id;
        $kardexs=Kardex::select('kardexes.*')
        ->where('kardexes.proveedor_id',$solicitudcarga->planta_id)
        ->get();

        $plantas = Planta::all();
        $productos = Producto::all();
        $cargas =  Carga::where('solicitud_cargas', $solicitudcargaId)->get();

        return Inertia::render('Cargas/Edit', [
            'solicitudcarga' => $solicitudcarga,
            'plantas'=>$plantas,
            'cargas'=>$cargas,
            'productos'=>$productos,
            'kardexs'=>$kardexs,
        ]);
    }

    public function update(Request $request, Solicitudcarga $solicitudcarga)
    {
        if($request->input('status') == 2)
        {
            $codigo = Solicitudcarga::generarCodigoSol($request);
            $solicitudcarga->fill([
                'codigo' => $codigo,
                'estado' => $request->input('status'),
            ]);
            $solicitudcarga->save();
        }else{
            $solicitudcarga->fill([
                'estado' => $request->input('status'),
            ]);
            $solicitudcarga->save();
        }

        if($request->input('carga') !== null){
        $solicitudcargaId = $solicitudcarga->id;
        $cargas =  Carga::where('solicitud_cargas', $solicitudcargaId)->get();
            foreach ($cargas as $carga) {
                $carga->delete();
            }
            //guardar el array de carga
            foreach ($request->input('carga') as $detail) {
                $carga = Carga::create([
                    'codigo_producto'   =>      $detail[0],
                    'nombre_producto'   =>      $detail[1],
                    'fecha_produccion'  =>      $detail[2],
                    'descripcion'       =>      $detail[3],
                    'lote'              =>      $detail[4],
                    'cantidad'          =>      $detail[5],
                    'kilosnetos'        =>      $detail[6],
                    'librasnetas'       =>      $detail[7],
                    'solicitud_cargas'  =>      $solicitudcarga->id,

                ]);
            }
        }

        return redirect('solicitudcargas');
    }

    public function destroy(Solicitudcarga $solicitudcarga)
    {
        $solicitudcarga->delete();
        return redirect('solicitudcargas');
    }
}
