<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conocimiento;
use App\Models\Solicitudcarga;
use App\Models\Carga;
use Illuminate\Support\Facades\DB;

class ComprobanteIngreso extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_ingreso',
        'fecha_ingreso',
        'cefo',
        'observaciones',
        'conocimiento_id',
    ];

    public static function generarCodigoIngreso($id)//uso
    {
        $lastDocument = ComprobanteIngreso::whereNotNull('codigo_ingreso')
        ->latest('comprobante_ingresos.id')
        ->first();

        $currentYear = date('y');

        if ($lastDocument !== null)
        {
            $lastNumber = (int) substr($lastDocument->codigo_ingreso, -4);
            $codigo = str_pad((int)$lastNumber + 1, 3, '0', STR_PAD_LEFT).'/'.$currentYear;
        }else{
            $codigo = '001/'.$currentYear;
        }
        return $codigo;
    }

    public static function indexIngreso ()//uso
    {
        $comprobanteIngreso = ComprobanteIngreso::select('comprobante_ingresos.*','plantas.nombre as plantas_nombre',
        'conocimientos.codigo')
        ->join('conocimientos','conocimientos.id','=','comprobante_ingresos.conocimiento_id')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
        ->get();

        return $comprobanteIngreso;
    }

    public static function crearIngreso ($request)//uso
    {
        $comprobanteIngreso = ComprobanteIngreso::create([
            'codigo_ingreso' => $request->input('codigo_ingreso'),
            'fecha_ingreso' => $request->input('fecha_ingreso'),
            'cefo' => $request->input('cefo'),
            'observaciones' => $request->input('observaciones'),
            'conocimiento_id' => $request->input('conocimiento_id'),
        ]);

        return $comprobanteIngreso;
    }

    public function conocimiento()
    {
        return $this->hasOne(Conocimiento::class, 'id','conocimiento_id');
    }

    public function vercargas()
    {
        return $this->hasManyThrough(
            Carga::class,
            Conocimiento::class,
            'id', // Clave Primaria de Conocimiento
            'solicitud_cargas', // Clave foránea en Carga
            'id', // Clave primaria de ComprobanteIngreso
            'solicitud_id' // Clave foranea en conocimiento
        );
    }

    public static function pdfIngreso($id)//uso
    {
        $comprobanteIngreso = ComprobanteIngreso::select('comprobante_ingresos.id','fecha_ingreso','codigo_ingreso',
        'cefo','observaciones','conocimientos.codigo','conocimientos.usuario_id as usuario_planta','conocimientos.empresa',
        'conocimientos.conductor','conocimientos.vehiculo','conocimientos.propietario','conocimientos.licencia',
        'conocimientos.placa','conocimientos.celular','conocimientos.estado','plantas.nombre as planta',
        'public._bp_usuarios.usr_usuario','conocimientos.solicitud_id',
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('conocimientos','conocimientos.id','=','comprobante_ingresos.conocimiento_id')
        ->join('solicitudcargas','solicitudcargas.id','=','conocimientos.solicitud_id')
        ->join('plantas','plantas.planta_id','=','solicitudcargas.planta_id')
        ->join('cargas', 'cargas.solicitud_cargas', '=', 'solicitudcargas.id')
        ->join('public._bp_usuarios', 'public._bp_usuarios.usr_id','=','conocimientos.usuario_id')
        ->groupBy('comprobante_ingresos.id','comprobante_ingresos.fecha_ingreso','comprobante_ingresos.codigo_ingreso',
                'comprobante_ingresos.cefo','comprobante_ingresos.observaciones','conocimientos.codigo','conocimientos.usuario_id',
                'conocimientos.empresa','conocimientos.conductor','conocimientos.vehiculo','conocimientos.propietario',
                'conocimientos.licencia','conocimientos.placa','conocimientos.celular', 'conocimientos.estado', 'plantas.nombre',
                'public._bp_usuarios.usr_usuario','conocimientos.solicitud_id')
        ->where('comprobante_ingresos.id', $id)->first();

        return $comprobanteIngreso;
    }

}
