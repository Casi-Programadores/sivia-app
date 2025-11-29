<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\SolicitudViatico;

class VerSolicitudViatico extends Component
{
    public SolicitudViatico $solicitud;

    // Livewire 3 maneja el Route Model Binding automáticamente en el mount
    public function mount(SolicitudViatico $solicitud)
    {
        // Cargamos todas las relaciones para optimizar la vista
        $this->solicitud = $solicitud->load([
            'empleados.persona', // Para ver nombres de los empleados
            'numeroNotaInterna',
            'distrito',
            'localidad',
            'porcentaje'
        ]);
    }

    public function render()
    {
        return view('livewire.solicitudes.ver-solicitud-viatico');
    }
}