<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {

        $admin = User::create([
            'usr_prs_id' => 1,
            'usr_usuario' => 'admin1.admin1',
            'password' => Hash::make('eba2024'),
            'usr_registrado' => now(),
            'usr_modificado' => now(),
            'usr_usr_id' => 1,
            'usr_estado' => 'A',
        ]);
        $admin->assignRole('admin');

        $oficina = User::create([
            'usr_prs_id' => 1,
            'usr_usuario' => 'oficina.oficina',
            'password' => Hash::make('eba2024'),
            'usr_registrado' => now(),
            'usr_modificado' => now(),
            'usr_usr_id' => 1,
            'usr_estado' => 'A',
        ]);
        $oficina->assignRole('oficina');

        $almacen = User::create([
            'usr_prs_id' => 1,
            'usr_usuario' => 'almacen.almacen',
            'password' => Hash::make('eba2024'),
            'usr_registrado' => now(),
            'usr_modificado' => now(),
            'usr_usr_id' => 1,
            'usr_estado' => 'A',
        ]);
        $almacen->assignRole('almacen');

        $planta = User::create([
            'usr_prs_id' => 1,
            'usr_usuario' => 'planta.planta',
            'password' => Hash::make('eba2024'),
            'usr_registrado' => now(),
            'usr_modificado' => now(),
            'usr_usr_id' => 1,
            'usr_estado' => 'A',
        ]);
        $planta->assignRole('planta');

        //$admin = User::create([
            //'ci' => '00000000',
            //'paterno' => 'admin',
            //'materno' => 'admin',
            //'name' => 'admin',
            //'email' => 'admin@eba.bo',
            //'password' => Hash::make('admin'),
            //'celular' => '00000000',
            //'estado' => 1,
        //]);
        //$admin->assignRole('admin');

        //$oficina = User::create([
            //'ci' => '12345678',
            //'paterno' => 'oficina',
            //'materno' => 'oficina',
            //'name' => 'oficina',
            //'email' => 'oficina@eba.bo',
            //'password' => Hash::make('eba2024'),
            //'celular' => '00000000',
            //'estado' => 1,
        //]);
        //$oficina->assignRole('oficina');

        //$almacen = User::create([
            //'ci' => '11111111',
            //'paterno' => 'Riberalta',
            //'materno' => 'Castillo',
            //'name' => 'Jose Luis',
            //'email' => 'almacen@eba.bo',
            //'password' => Hash::make('eba2024'),
            //'celular' => '00000000',
            //'estado' => 1,
        //]);
        //$almacen->assignRole('almacen');

        //USUARIOS PLANTAS
        //$planta = User::create([
            //'ci' => '22222222',
            //'paterno' => 'Gutierrez',
            //'materno' => 'Medina',
            //'name' => 'Felin',
            //'email' => 'planta@eba.bo',
            //'password' => Hash::make('eba2024'),
            //'celular' => '00000000',
            //'estado' => 1,
        //]);
        //$planta->assignRole('planta');

    }
}
