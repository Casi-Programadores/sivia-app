<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatosInicialesSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        DB::table('roles')->insert([
            ['nombre_rol' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_rol' => 'Usuario', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Usuario 
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('12345678'),
            'role_id' => 1, // Relacionado al rol Administrador
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Departamentos
        DB::table('departamentos')->insert([
            ['departamento' => 'Ingeniería Vial', 'created_at' => now(), 'updated_at' => now()],
            ['departamento' => 'Recursos Humanos', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Distritos
        DB::table('distritos')->insert([
            ['distrito' => 'Noroeste', 'created_at' => now(), 'updated_at' => now()],
            ['distrito' => 'Centro', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Porcentajes
        DB::table('porcentajes')->insert([
            ['porcentaje' => 100.00, 'created_at' => now(), 'updated_at' => now()],
            ['porcentaje' => 50.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Clases
        DB::table('clases')->insert([
            ['numero_clase' => '101', 'created_at' => now(), 'updated_at' => now()],
            ['numero_clase' => '102', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Personas
        DB::table('personas')->insert([
            ['nombre' => 'Juan', 'apellido' => 'Pérez', 'dni' => '12345678', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'María', 'apellido' => 'Gómez', 'dni' => '87654321', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Localidades
        DB::table('localidades')->insert([
            ['nombre_localidades' => 'Formosa', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_localidades' => 'Clorinda', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Número de nota interna
        DB::table('numero_nota_interna')->insert([
            ['numero' => 277, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Empleados (ejemplo, suponiendo que ya existen IDs en las tablas relacionadas)
        DB::table('empleados')->insert([
            [
                'persona_id' => 1,
                'numero_legajo' => 'LEG-001',
                'departamento_id' => 1,
                'distrito_id' => 1,
                'rol_id' => 1,
                'clase_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'persona_id' => 2,
                'numero_legajo' => 'LEG-002',
                'departamento_id' => 2,
                'distrito_id' => 2,
                'rol_id' => 2,
                'clase_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}