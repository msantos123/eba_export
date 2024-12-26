<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carga;
use App\Models\SalidaInventarioDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Solicitudcarga extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'usuario_id',
        'planta_id',
        'salida_inventario',
        'tipo',
        'estado',
    ];

    public static function indexSolicitudCarga()//uso
    {
        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo','plantas.planta_id as planta_id',
        'solicitudcargas.estado','public._bp_usuarios.usr_usuario as usuario','plantas.nombre as planta',
        DB::raw('DATE(solicitudcargas.created_at) as fecha'),
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
        ->join('public._bp_usuarios', 'public._bp_usuarios.usr_id','=','solicitudcargas.usuario_id')
        ->join('cargas', 'cargas.solicitud_cargas', '=', 'solicitudcargas.id')
        ->where('solicitudcargas.tipo','INGRESO')
        ->groupBy('solicitudcargas.id','solicitudcargas.created_at','solicitudcargas.codigo',
        'solicitudcargas.estado', 'public._bp_usuarios.usr_usuario','plantas.nombre','plantas.id')
        ->orderBy('plantas.nombre')
        ->orderBy('solicitudcargas.codigo')
        ->with('listaLotes')
        ->get();

        return $solicitudcarga;
    }

    public static function verSolicitudcarga($solicitudId)//uso
    {
        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo',
        'solicitudcargas.usuario_id','solicitudcargas.planta_id','solicitudcargas.salida_inventario','solicitudcargas.created_at',
        'solicitudcargas.estado','public._bp_usuarios.usr_usuario as nombre','plantas.nombre as planta_nombre')
        ->join('public._bp_usuarios', 'public._bp_usuarios.usr_id','=','solicitudcargas.usuario_id')
        ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
        ->where('solicitudcargas.id',$solicitudId)->first();

        return $solicitudcarga;
    }

    public static function crearSolicitudcarga($data)//uso
    {
        // Crear la solicitud
        $solicitudcarga = self::create([
            'planta_id' => $data['planta_id'],
            'usuario_id' => $data['usuario_id'],
            'tipo' => 'INGRESO',
        ]);
        $solicitudcargaId = $solicitudcarga->id;

        foreach ($data['carga'] as $detail) {

            $numeroLote = $detail[2];
            $lote = '';
            switch ($data['planta_id']) {
                case 9:
                    $lote = 'FOR.-' . str_pad($numeroLote, 3, '0', STR_PAD_LEFT) . '(EA)';
                    break;
                case 10:
                    $lote = 'EA-' . str_pad($numeroLote, 3, '0', STR_PAD_LEFT);
                    break;
                case 25:
                    $lote = 'FO-' . str_pad($numeroLote, 3, '0', STR_PAD_LEFT) . '(EA)';
                    break;
                default:
                    // Manejar el caso por defecto si es necesario
                    $lote = 'DEFAULT-0' . str_pad($numeroLote, 3, '0', STR_PAD_LEFT);
                    break;
            }

            $solicitudcarga->cargas()->create([
                'codigo_producto'   => $detail[0],
                'nombre_producto'   => $detail[1],
                'lote'              => $lote,
                'calidad'           => $detail[3],
                'descripcion'       => $detail[4],
                'cantidad'          => $detail[5],
                'kilosnetos'        => $detail[6],
                'librasnetas'       => $detail[7],
                'receta_id'         => $detail[8],
                'solicitud_cargas'  => $solicitudcargaId,
            ]);
        }

        return $solicitudcarga;
    }

    public static function generarCodigoSol($request)//uso
    {
        $lastDocument = Solicitudcarga::select('solicitudcargas.id','codigo')
        ->where('solicitudcargas.planta_id', $request->solicitudcarga['planta_id'])
        ->where('solicitudcargas.tipo', 'INGRESO')
        ->whereNotNull('codigo')
        ->latest('solicitudcargas.id')
        ->first();
        //Log::info('Código generado:', ['lastDocument' => $lastDocument]);
        $currentYear = date('y');
        if ($lastDocument !== null) {
            $lastNumber = (int) substr($lastDocument->codigo, -4);
            $codigo = 'SOL.PLA-'.str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
        } else {
            $codigo = 'SOL.PLA-001/'.$currentYear;
        }
        return $codigo;
    }

    public function listaLotes()//uso
    {
        return $this->hasMany(Carga::class,'solicitud_cargas','id');
    }

    public static function crearSolicitudcargaAlmacen($data)//uso
    {
        // Crear la solicitud
        $solicitudcarga = self::create([
            'planta_id' => $data['planta_id'], // Cambiado de $data->planta_id a $data['planta_id']
            'usuario_id' => $data['usuario_id'],
            'tipo' => 'SALIDA',
        ]);

        $solicitudcargaId = $solicitudcarga->id;

        // Crear las cargas
        foreach ($data['carga'] as $detail) {
            $solicitudcarga->cargas()->create([
                'codigo_producto'   => $detail[0],
                'nombre_producto'   => $detail[1],
                'lote'              => $detail[2],
                'descripcion'       => $detail[3],
                'cantidad'          => $detail[4],
                'kilosnetos'        => $detail[5],
                'librasnetas'       => $detail[6],
                'receta_id'         => $detail[7],
                'kardex_id'         => $detail[8],
                'solicitud_cargas'  => $solicitudcargaId,
            ]);
        }

        return $solicitudcarga;
    }

    public static function generarCodigoSolAlmacen()//uso
    {
        $lastDocument = Solicitudcarga::select('solicitudcargas.id','codigo')
        ->where('solicitudcargas.tipo', 'SALIDA')
        ->whereNotNull('codigo')
        ->latest('solicitudcargas.id')
        ->first();
        $currentYear = date('y');
        if ($lastDocument !== null) {
            $lastNumber = (int) substr($lastDocument->codigo, -4);
            $codigo = 'SOL.ALM-'.str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
        } else {
            $codigo = 'SOL.ALM-001/'.$currentYear;
        }
        return $codigo;
    }

    public function cargas()
    {
        return $this->hasMany(Carga::class, 'solicitud_cargas'); // Asegúrate de que el nombre de la columna sea correcto
    }

    public static function indexSolicitudCargaAlmacen()//uso
    {
        $solicitudcarga = Solicitudcarga::select('solicitudcargas.id','solicitudcargas.codigo',
        'solicitudcargas.estado','public._bp_usuarios.usr_usuario as usuario','plantas.nombre as planta',
        DB::raw('DATE(solicitudcargas.created_at) as fecha'),
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
        ->join('public._bp_usuarios', 'public._bp_usuarios.usr_id','=','solicitudcargas.usuario_id')
        ->join('cargas', 'cargas.solicitud_cargas', '=', 'solicitudcargas.id')
        ->where('solicitudcargas.tipo','SALIDA')
        ->groupBy('solicitudcargas.id','solicitudcargas.created_at','solicitudcargas.codigo',
        'solicitudcargas.estado', 'public._bp_usuarios.usr_usuario','plantas.nombre')
        ->orderBy('plantas.nombre')
        ->orderBy('solicitudcargas.codigo')
        ->get();

        return $solicitudcarga;
    }
}
