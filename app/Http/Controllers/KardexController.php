<?php
namespace App\Http\Controllers;
use App\Models\Kardex;
use App\Models\DetalleKardex;
use App\Models\ComprobanteIngreso;
use Illuminate\Http\Request;
use Inertia\Inertia;


class KardexController extends Controller
{

    public function index()//uso
    {
        $kardex = Kardex::select('kardexes.id','codigo_producto',
        'articulo','proveedor_id','unidad','lote','saldo','plantas.nombre as plantas_nombre')
        ->join('plantas','plantas.planta_id','=','kardexes.proveedor_id')
        ->orderBy('codigo_producto', 'asc')
        ->get();
        return Inertia::render('Kardex/Index', [
            'kardex' => $kardex,
        ]);
    }

    public function store(Request $request)//uso
    {
        try {
            foreach ($request->cargas as $index => $carga) {
                // Verifica si el lote ya existe
                $existingKardex = Kardex::where('lote', $carga['lote'])
                    ->where('proveedor_id', $request->planta_id)
                    ->first();

                if ($existingKardex !== null) {
                    // Si el lote existe, suma la cantidad al saldo
                    $existingKardex->saldo += $carga['cantidad'];
                    $existingKardex->save();

                    // Guarda el detalle con el kardex existente
                    DetalleKardex::create([
                        'kardex_id' => $existingKardex->id,
                        'tipo_movimiento' => 'Ingreso',
                        'empresa' => $request->input('empresa'),
                        'codigo_conocimiento' => $request->input('codigo_conocimiento'),
                        'ingreso_id' => $request->input('id_ingreso'),
                        'ingreso' => $carga['cantidad'],
                    ]);
                } else {
                    // Si no existe, crea un nuevo registro de Kardex
                    $kardex = Kardex::create([
                        'codigo_producto' => $carga['codigo_producto'],
                        'articulo' => $carga['nombre_producto'],
                        'proveedor_id' => $request->input('planta_id'),
                        'ubicacion' => 'Almacen EBA El Alto',
                        'lote' => $carga['lote'],
                        'saldo' => $carga['cantidad'],
                        'receta_id' => $carga['receta_id'],
                    ]);

                    // Guarda el detalle con el nuevo kardex
                    DetalleKardex::create([
                        'kardex_id' => $kardex->id,
                        'tipo_movimiento' => 'Ingreso',
                        'empresa' => $request->input('empresa'),
                        'codigo_conocimiento' => $request->input('codigo_conocimiento'),
                        'ingreso_id' => $request->input('id_ingreso'),
                        'ingreso' => $carga['cantidad'],
                    ]);
                }

                // Cambia el estado de ComprobanteIngreso
                $comprobanteIngreso = ComprobanteIngreso::find($request->input('id_ingreso'));
                if ($comprobanteIngreso) {
                    $comprobanteIngreso->estado = $request->input('status');
                    $comprobanteIngreso->save();
                }
            }

            // Retornar una respuesta JSON de éxito
            return response()->json(['message' => 'Kardex guardado exitosamente.'], 200);
        } catch (\Exception $e) {
            // Manejo de errores en caso de excepción
            return response()->json(['message' => 'Ocurrió un error al guardar el kardex.'], 500);
        }
    }

    public function show($id)//uso
    {
        $detallekardex = DetalleKardex::select('detalle_kardexes.*',
        'kardexes.saldo as saldo',
        'comprobante_ingresos.fecha_ingreso as fechaIngreso',
        'comprobante_ingresos.codigo_ingreso as codigoIngreso',
        'comprobante_salidas.fecha_salida as fechaSalida',
        'comprobante_salidas.codigo_salida as codigoSalida')
        ->leftJoin('kardexes','kardexes.id','=','detalle_kardexes.kardex_id')
        ->leftJoin('comprobante_ingresos','comprobante_ingresos.id','=','detalle_kardexes.ingreso_id')
        ->leftJoin('comprobante_salidas','comprobante_salidas.id','=','detalle_kardexes.salida_id')
        ->where('detalle_kardexes.kardex_id',$id)->get();

        $kardex = Kardex::select('kardexes.*','plantas.nombre as plantas_nombre')
        ->join('plantas','plantas.planta_id','=','kardexes.proveedor_id')
        ->where('kardexes.id',$id)
        ->first();

        return Inertia::render('Kardex/Edit', [
            'kardex' => $kardex,
            'detallekardex' => $detallekardex,
        ]);
    }
}
