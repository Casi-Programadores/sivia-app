<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\User;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole = Rol::firstOrCreate(['nombre_rol' => 'admin']);
        $userRole  = Rol::firstOrCreate(['nombre_rol' => 'user']);

        // Usuario admin
        User::firstOrCreate(
            ['email' => 'admin@tudominio.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // Usuario normal
        User::firstOrCreate(
            ['email' => 'usuario@tudominio.com'],
            [
                'name' => 'Usuario Normal',
                'password' => bcrypt('password'),
                'role_id' => $userRole->id,
            ]
        );

        $this->command->info('Roles y usuarios iniciales creados correctamente.');
    }
}
