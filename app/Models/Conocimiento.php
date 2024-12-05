<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Solicitudcarga;
use App\Models\Carga;
use Illuminate\Support\Facades\DB;

class Conocimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'usuario_id',
        'empresa',
        'conductor',
        'vehiculo',
        'propietario',
        'licencia',
        'placa',
        'celular',
        'solicitud_id',
        'estado',
    ];

    public static function generarCodigoConocimiento($request)//uso
    {
        $lastDocument = Conocimiento::select('conocimientos.codigo')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->where('solicitudcargas.planta_id', $request->planta_id)
        ->whereNotNull('conocimientos.codigo')
        ->latest('conocimientos.id')
        ->first();

        $currentYear = date('y');

        if ($lastDocument!==null) {
            $lastNumber = (int) substr($lastDocument->codigo, -4);
            $codigo = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
        } else {
            $codigo = '001/'.$currentYear;
        }
        return $codigo;
    }


    public static function indexConocimiento()//uso
    {
        $conocimiento = Conocimiento::select('conocimientos.id','conocimientos.codigo',
        'empresa','conductor','vehiculo','placa','celular','conocimientos.estado','conocimientos.pdf_conocimiento',
        'solicitudcargas.planta_id as planta','plantas.nombre as plantaNombre')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
        ->orderBy('plantas.nombre')
        ->orderBy('conocimientos.codigo')
        ->get();

        return $conocimiento;
    }

    public static function pdfConocimiento ($id)//uso
    {
        $conocimientos = Conocimiento::select('conocimientos.id','conocimientos.codigo',
        'conocimientos.usuario_id as usuario_planta','empresa','conductor','vehiculo',
        'propietario','licencia','placa','conocimientos.celular','conocimientos.estado',
        'plantas.nombre as planta','public._bp_usuarios.usr_usuario','conocimientos.solicitud_id',
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
        ->join('cargas', 'cargas.solicitud_cargas', '=', 'solicitudcargas.id')
        ->join('public._bp_usuarios', 'public._bp_usuarios.usr_id','=','conocimientos.usuario_id')
        ->groupBy('conocimientos.id', 'conocimientos.codigo', 'conocimientos.usuario_id',
                'empresa', 'conductor', 'vehiculo', 'propietario', 'licencia', 'placa',
                'conocimientos.celular', 'conocimientos.estado', 'plantas.nombre', 'public._bp_usuarios.usr_usuario'
                ,'conocimientos.solicitud_id')
        ->where('conocimientos.id', $id)->first();

        return $conocimientos;
    }

    public static function guardarConocimiento ($request)//uso
    {
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

        return $conocimiento;
    }

    //public function carga()
    //{
    //return $this->hasOne(Carga::class, 'solicitud_id', 'solicitud_id');
    //}


}
