<?php

namespace App\Livewire\Usuarios;

use App\Livewire\PlantillasGenerales\PlantillaTablaDatos; 
use Illuminate\Database\Eloquent\Builder;
use App\Models\User; //Importar modelo 

// Extiende de tu clase base
class UsuarioTable extends PlantillaTablaDatos
{

    public function mount()
    {
        // 1. Asignar el modelo de la Vista SQL
        $this->modelo = User::class; 

        // 2. Actualizar columnas: Ahora son directas de la vista
        $this->bucadorComlumnas = [
            'name',
            'email'      
        ];

        $this->filas = [
            'id',
            'name',
            'email'
        ];

        $this->columnas = [
            'ID',
            'Nombre Usuario', 
            'Correo Electronico'
        ];
    }

    /**
     * El método buildQuery ya NO necesita sobrescribir la lógica de JOINs (with)
     */
    protected function buildQuery(): Builder
    {
        // La lógica de búsqueda (parent::buildQuery()) ahora funciona con OR WHERE
        // directamente en las columnas de la vista, sin necesidad de joins complejos.
        return parent::buildQuery(); 
    }
}