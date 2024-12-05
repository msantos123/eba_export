<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PlantaSeeder;
use Database\Seeders\UsuarioSeeder;
//use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UsuarioSeeder::class,
            PlantaSeeder::class,

        ]);
    }
}
