<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\SolicitudViatico;

class VerSolicitudViatico extends Component
{
    public SolicitudViatico $solicitud;

    public function mount(SolicitudViatico $solicitud)
    {
        // Cargamos todas las relaciones para optimizar la vista
        $this->solicitud = $solicitud->load([
            'empleados.persona', 
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

    public function verPDF($id)
    {
        return redirect()->to("/solicitud/pdf/" . $id);
    }
    
}