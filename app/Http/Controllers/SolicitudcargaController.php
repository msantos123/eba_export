<?php

namespace App\Http\Controllers;
//modelos
use App\Models\Planta;
use App\Models\Producto;
use App\Models\Carga;
use App\Models\User;
use App\Models\Solicitudcarga;
use App\Models\Kardex;
use App\Models\Inventario;
use App\Models\CargaDetalle;
use App\Models\SalidaInventario;
use App\Models\SalidaInventarioDetalle;
use App\Models\SigaSalidaDetalle;
//request
use App\Http\Requests\SolicitudcargaRequest;
//otros
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SolicitudcargaController extends Controller
{
    public function index()//uso
    {
        $solicitudcarga = Solicitudcarga::indexSolicitudCarga();
        $plantas = Planta::all();
        return Inertia::render('Cargas/Index',[
            'solicitudcarga'=>$solicitudcarga,
            'plantas'=>$plantas,
        ]);
    }

    public function show($id)//uso
    {
        $solicitudcarga = Solicitudcarga::verSolicitudcarga($id);
        $cargas = Carga::where('solicitud_cargas',$id)->get();
        return Inertia::render('Cargas/Show', [
            'cargas' => $cargas,
            'solicitudcarga' => $solicitudcarga,
        ]);
    }

    public function delete($id)//uso
    {
        $solicitudCarga = SolicitudCarga::find($id);

        if (!$solicitudCarga) {
            return response()->json(['error' => 'Solicitud de carga no encontrada.'], 404);
        }

        $solicitudCarga->delete();
        return response()->json(['success' => 'Solicitud de carga eliminada con éxito.']);
    }

    public function store(Request $request)//uso
    {
        $request->merge(['usuario_id' => auth()->id()]);
        Solicitudcarga::crearSolicitudcarga($request->all());
        return redirect('solicitudcargas/index');
    }

    public function edit($id, $planta_id)//uso
    {
        $solicitudcarga = Solicitudcarga::find($id);
        $cargas = Carga::where('solicitud_cargas',$id)->get();
        $salidaInventario = SalidaInventario::indexSalidaInventario($planta_id);

        return Inertia::render('Cargas/Edit', [
            'cargas' => $cargas,
            'planta_id' =>$planta_id,
            'solicitudcarga' => $solicitudcarga,
            'salidaInventario' => $salidaInventario,
        ]);
    }

    public function update(Request $request)//uso
    {
        try {
            $codigo = Solicitudcarga::generarCodigoSol($request);
            $salidaInventario = $request->salida_detalle[0]['mvdpt_mvpt_id'];

            $solicitudcarga = Solicitudcarga::find($request->solicitudcarga['id']);
            $solicitudcarga->fill([
                'codigo' => $codigo,
                'salida_inventario' => $salidaInventario,
                'estado' => 1,
            ]);
            $solicitudcarga->save();

            // Obtener las cargas relacionadas
            $cargas = Carga::where('solicitud_cargas', $request->solicitudcarga['id'])->get();
            // Obtener los detalles de salida de inventario
            $salida_inventario_detalle = SalidaInventarioDetalle::verSalidaPlanta($salidaInventario);
            foreach ($cargas as $carga) {
                foreach ($salida_inventario_detalle as $detalle) {
                    SigaSalidaDetalle::create([
                        'detalle_id'        => $detalle->mvdpt_id,
                        'salida_id'         => $detalle->mvdpt_mvpt_id,
                        'rece_id'           => $detalle->mvdpt_rece_id,
                        'cantidad_detalle'  => $detalle->mvdpt_cantidad,
                        'lote_detalle'      => $carga->lote,
                        'fecha_elaboracion' => $detalle->mvdpt_fec_elaboracion,
                        'fecha_vencimiento' => $detalle->mvdpt_fec_vencimiento,
                        'fecha_envasado'    => $detalle->mvdpt_fec_envasado,
                        'cargaIngreso_id'   => $carga->id,
                    ]);
                }
            }

            return response()->json('Guardado exitosamente');
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json('No se guardó: ' . $e->getMessage(), 500);
        }
    }

    public function crearSolicitud($planta_id)//uso
    {
        $inventarios = Inventario::productoPlanta($planta_id);
        $planta = Planta::where('planta_id',$planta_id)->first();

        return Inertia::render('Cargas/Create',[
            'inventarios'=>$inventarios,
            'planta' => $planta,
        ]);
    }

    public function updateAlmacen($id)//uso
    {
        $solicitudcarga = Solicitudcarga::find($id);

        if (!$solicitudcarga) {
            return response()->json(['message' => 'Solicitud no encontrada.'], 404);
        }

        $codigo = Solicitudcarga::generarCodigoSolAlmacen();
        $solicitudcarga->fill([
            'codigo' => $codigo,
            'estado' => 1,
        ]);

        $solicitudcarga->save();

        // Retorna una respuesta JSON de éxito
        return response()->json(['message' => 'Solicitud actualizada exitosamente.'], 200);
    }

    public function update_costo(Request $request)
    {
        // Actualizar las cargas
        foreach ($request->all() as $cargaData) {
            $carga = Carga::find($cargaData['id']);
            $carga->costo_caja = $cargaData['costo_caja'];
            // Aquí puedes agregar más campos que necesites actualizar
            $carga->save();
        }

        return response()->json(['message' => 'Costos actualizados correctamente.'], 200);
        //return response()->json($request);
    }


}
