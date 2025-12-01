<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Primero roles y usuarios
        $this->call(RoleAndUserSeeder::class);

        // Luego datos iniciales
        $this->call(DatosInicialesSeeder::class);
    }
}
