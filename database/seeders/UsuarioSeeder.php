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

        $admin = User::where('usr_usuario', 'roberto.ojeda')->first();

        if ($admin) {
            $admin->assignRole('admin');
        } else {
            // No se encuentra el usuario, puedes registrar un mensaje si lo deseas
            \Log::info('Usuario roberto.ojeda no encontrado, no se asigna rol.');
        }
    }

}

        //$oficina = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'oficina.oficina',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);
        //$oficina->assignRole('oficina');

        //$almacen = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'almacen.almacen',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);
        //$almacen->assignRole('almacen');

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'planta.planta',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);
        //$planta->assignRole('planta');

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'roberto.ojeda',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'jorge.clemente',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'maria.mamani',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'linda.choque',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'shirley.acho',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'miriam.guerra',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);

        //$planta = User::create([
            //'usr_prs_id' => 1,
            //'usr_usuario' => 'manuel.santos',
            //'password' => Hash::make('eba2024'),
            //'usr_registrado' => now(),
            //'usr_modificado' => now(),
            //'usr_usr_id' => 1,
            //'usr_estado' => 'A',
        //]);


