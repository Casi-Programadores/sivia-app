<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\SolicitudViatico;
use Luecano\NumeroALetras\NumeroALetras; 

class VerSolicitudViatico extends Component
{
    public SolicitudViatico $solicitud;
     public $montoEnLetras; 

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

        $formatter = new NumeroALetras();
        $this->montoEnLetras = $formatter->toMoney($this->solicitud->monto_total, 2, 'PESOS', 'CENTAVOS');
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