<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //$platas = Planta::all();
        $admin = User::create([
            'ci' => '00000000',
            'paterno' => 'admin',
            'materno' => 'admin',
            'name' => 'admin',
            'email' => 'admin@eba.bo',
            'password' => Hash::make('admin'),
            'planta_id' => 0,
            'celular' => '00000000',
            'rol' => 1,
            'estado' => 1,
        ]);
        $admin->assignRole('admin');

        $oficina = User::create([
            'ci' => '12345678',
            'paterno' => 'oficina',
            'materno' => 'oficina',
            'name' => 'oficina',
            'email' => 'oficina@eba.bo',
            'password' => Hash::make('eba2024'),
            'planta_id' => 1,
            'celular' => '00000000',
            'rol' => 1,
            'estado' => 1,
        ]);
        $oficina->assignRole('oficina');

        $almacen = User::create([
            'ci' => '11111111',
            'paterno' => 'Riberalta',
            'materno' => 'Castillo',
            'name' => 'Jose Luis',
            'email' => 'almacen@eba.bo',
            'password' => Hash::make('eba2024'),
            'planta_id' => 2,
            'celular' => '00000000',
            'rol' => 1,
            'estado' => 1,
        ]);
        $almacen->assignRole('almacen');

        //USUARIOS PLANTAS
        $planta = User::create([
            'ci' => '22222222',
            'paterno' => 'Gutierrez',
            'materno' => 'Medina',
            'name' => 'Felin',
            'email' => 'planta@eba.bo',
            'password' => Hash::make('eba2024'),
            'planta_id' => 3,
            'celular' => '00000000',
            'rol' => 1,
            'estado' => 1,
        ]);
        $planta->assignRole('planta');

    }
}
