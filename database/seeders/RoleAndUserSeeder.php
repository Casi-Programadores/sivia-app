<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\User;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Rol::firstOrCreate(['nombre_rol' => 'admin']);
        $userRole  = Rol::firstOrCreate(['nombre_rol' => 'user']);

        // Crear usuario admin
        User::firstOrCreate(
            ['email' => 'admin@tudominio.com'],
            [
                'name' => 'Administrador',
                'password' => 'password', // Laravel 10 lo hashea automáticamente
                'role_id' => $adminRole->id,
            ]
        );

        // Crear usuario normal
        User::firstOrCreate(
            ['email' => 'usuario@tudominio.com'],
            [
                'name' => 'Usuario Normal',
                'password' => 'password',
                'role_id' => $userRole->id,
            ]
        );

        $this->command->info('Roles y usuarios iniciales creados correctamente.');
    }
}
