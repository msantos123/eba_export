<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleSalida;
use Illuminate\Support\Facades\DB;

class ComprobanteSalida extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_salida',
        'empresa',
        'responsable',
        'camion',
        'placa',
        'licencia',
        'celular',
        'contenedor',
        'presinto',
        'reserva',
        'factura',
        'destino',
        'codigo_salida',
    ];

    public function solicitudCarga()
    {
        return $this->hasOne(SolicitudCarga::class, 'salida_inventario', 'id');
    }

    public function solicitudCargas()
    {
        return $this->hasMany(SolicitudCarga::class, 'salida_inventario', 'id');
    }

    public static function generarCodigoSalida()//uso
    {
        $lastDocument = ComprobanteSalida::whereNotNull('codigo_salida')
            ->latest('id') // Asegúrate de que 'id' es el campo correcto
            ->first();

        $currentYear = date('y');

        if ($lastDocument !== null) {
            // Cambia 'codigo_ingreso' a 'codigo_salida'
            $lastNumber = (int) substr($lastDocument->codigo_salida, -7, 3); // Cambia -4 a -7 para incluir la barra
            $codigo = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT) . '/' . $currentYear;
        } else {
            $codigo = '001/' . $currentYear;
        }

        return $codigo;
    }

    public static function pdfSalida($id)//uso
    {
        $comprobanteSalida = ComprobanteSalida::select('comprobante_salidas.*','solicitudcargas.id as solicitud_id',
        DB::raw('SUM(cargas.cantidad) as total_cantidad'),
        DB::raw('SUM(cargas.kilosnetos) as total_kilosnetos'),
        DB::raw('SUM(cargas.librasnetas) as total_librasnetas'))
        ->join('solicitudcargas','solicitudcargas.salida_inventario','=','comprobante_salidas.id')
        ->join('cargas','cargas.solicitud_cargas','=','solicitudcargas.id')
        ->groupBy('comprobante_salidas.id','fecha_salida','codigo_salida','solicitudcargas.id',
        'comprobante_salidas.empresa','comprobante_salidas.responsable','comprobante_salidas.camion',
        'comprobante_salidas.placa','comprobante_salidas.licencia','comprobante_salidas.celular',
        'comprobante_salidas.contenedor','comprobante_salidas.presinto','comprobante_salidas.reserva',
        'comprobante_salidas.factura','comprobante_salidas.destino')
        ->where('comprobante_salidas.id', $id)->first();

        //dd($comprobanteSalida);

        return $comprobanteSalida;
    }
}
