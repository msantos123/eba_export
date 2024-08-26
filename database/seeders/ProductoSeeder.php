<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        //CALIDAD CONVENCIONAL
        Producto::create([
            'codigo_producto' => 'EBA-MDM-C-20K',
            'nombre_producto' => 'MEDIUM CONVENCIONAL',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-MGT-C-20K',
            'nombre_producto' => 'MIDGET CONVENCIONAL',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-TNY-C-20K',
            'nombre_producto' => 'TINNY CONVENCIONAL',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-CPD-C-20K',
            'nombre_producto' => 'CHIPPED CONVENCIONAL',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-BKN-C-20K',
            'nombre_producto' => 'BROKEN CONVENCIONAL',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-BKND-C-20K',
            'nombre_producto' => 'BROKEN D CONVENCIONAL',
        ]);

        //CALIDAD ORGANICO
        Producto::create([
            'codigo_producto' => 'EBA-MDM-O-20K',
            'nombre_producto' => 'MEDIUM ORGANICO',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-MGT-O-20K',
            'nombre_producto' => 'MIDGET ORGANICO',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-TNY-O-20K',
            'nombre_producto' => 'TINNY ORGANICO',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-CPD-O-20K',
            'nombre_producto' => 'CHIPPED ORGANICO',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-BKN-O-20K',
            'nombre_producto' => 'BROKEN ORGANICO',
        ]);
        Producto::create([
            'codigo_producto' => 'EBA-BKND-O-20K',
            'nombre_producto' => 'BROKEN D ORGANICO',
        ]);
    }
}
