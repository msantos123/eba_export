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
            'planta_id' => '9',
            'nombre' => 'Planta Industrial Riberalta',
            'direccion' => 'Av. Desconocido, Zona Desconocido #100',
            'tipo' => 'Planta',
        ]);
        Planta::create([
            'planta_id' => '10',
            'nombre' => 'Planta Industrial Sena',
            'direccion' => 'Av. Desconocido, Zona Desconocido #100',
            'tipo' => 'Planta',
        ]);
        Planta::create([
            'planta_id' => '25',
            'nombre' => 'Planta Industrial Cobija',
            'direccion' => 'Av. Desconocido, Zona Desconocido #100',
            'tipo' => 'Planta',
        ]);
    }
}
