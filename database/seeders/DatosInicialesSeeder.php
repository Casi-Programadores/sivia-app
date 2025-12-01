<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatosInicialesSeeder extends Seeder
{
    public function run(): void
    {
        // Departamentos
        DB::table('departamentos')->insertOrIgnore([
            ['departamento' => 'Ingeniería Vial', 'created_at' => now(), 'updated_at' => now()],
            ['departamento' => 'Construcciones', 'created_at' => now(), 'updated_at' => now()],
            ['departamento' => 'Conservacion', 'created_at' => now(), 'updated_at' => now()],
            ['departamento' => 'Mantenimiento', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Distritos
        DB::table('distritos')->insertOrIgnore([
            ['distrito' => 'Extremo Oeste', 'created_at' => now(), 'updated_at' => now()],
            ['distrito' => 'Oeste', 'created_at' => now(), 'updated_at' => now()],
            ['distrito' => 'Noroeste', 'created_at' => now(), 'updated_at' => now()],
            ['distrito' => 'Sur', 'created_at' => now(), 'updated_at' => now()],
            ['distrito' => 'Centro', 'created_at' => now(), 'updated_at' => now()],
            ['distrito' => 'Norte', 'created_at' => now(), 'updated_at' => now()],
            ['distrito' => 'Capital', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Porcentajes
        DB::table('porcentajes')->insertOrIgnore([
            ['porcentaje' => 100.00, 'created_at' => now(), 'updated_at' => now()],
            ['porcentaje' => 50.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Clases
        DB::table('clases')->insertOrIgnore([
            ['numero_clase' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['numero_clase' => '11', 'created_at' => now(), 'updated_at' => now()],
            ['numero_clase' => '12', 'created_at' => now(), 'updated_at' => now()],
            ['numero_clase' => '13', 'created_at' => now(), 'updated_at' => now()],
            ['numero_clase' => '14', 'created_at' => now(), 'updated_at' => now()],
            ['numero_clase' => '15', 'created_at' => now(), 'updated_at' => now()],
            ['numero_clase' => '16', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Personas
        DB::table('personas')->insertOrIgnore([
            ['nombre' => 'Juan', 'apellido' => 'Pérez', 'dni' => '34345678', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'María', 'apellido' => 'Gómez', 'dni' => '36123456', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sebastian', 'apellido' => 'Mora', 'dni' => '3812379', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Localidades
        $localidades = [
            'Clorinda','Comandante Fontana','El Colorado','El Espinillo','Estanislao del Campo','Formosa',
            'General Lucio Mansilla','General Belgrano','General Mosconi','Herradura','Ibarreta',
            'Ingeniero Juárez','Laguna Blanca','Laguna Naick Neck','Laguna Yema','Las Lomitas',
            'Mayor Vicente Villafañe','Misión San Fco de Laishí','Misión Tacaaglé','Palo Santo','Pirané',
            'Pozo del Tigre','Riacho He-Hé','San Martín II','Villa Dos Trece','Villa Escobar',
            'Villa General Guemes','Tatané'
        ];

        foreach ($localidades as $localidad) {
            DB::table('localidades')->insertOrIgnore([
                'nombre_localidades' => $localidad,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
