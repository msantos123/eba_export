<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Planta;

class PlantaSeeder extends Seeder
{
    public function run(): void
    {

        Planta::create([
            'nombre' => 'Oficina Central',
            'direccion' => 'Av. Arce, Zona Sopocachi #20',
            'tipo' => 'Oficina',
        ]);
        Planta::create([
            'nombre' => 'Almacen de Exportaciones EL ALTO - LA PAZ',
            'direccion' => 'Zona Villa Mercedez "E", Av. Simón Bolívar #210',
            'tipo' => 'Almacen',
        ]);
        Planta::create([
            'nombre' => 'Planta Industrial Riberalta',
            'direccion' => 'Av. Desconocido, Zona Desconocido #100',
            'tipo' => 'Planta',
        ]);
        Planta::create([
            'nombre' => 'Planta Industrial Sena',
            'direccion' => 'Av. Desconocido, Zona Desconocido #100',
            'tipo' => 'Planta',
        ]);
        Planta::create([
            'nombre' => 'Planta Industrial Cobija',
            'direccion' => 'Av. Desconocido, Zona Desconocido #100',
            'tipo' => 'Planta',
        ]);
    }
}
