<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\SolicitudViatico;

class UltimasSolicitudesTabla extends Component
{
    public function render()
    {
        $solicitudes = SolicitudViatico::with(['distrito', 'localidad', 'numeroNotaInterna']) // Agrega 'detalles.estado' si lo tienes
            ->latest()
            ->take(5)
            ->get();
            
        return view('livewire.solicitudes.ultimas-solicitudes-tabla', [
            'solicitudes' => $solicitudes
        ]);
    }

    
}

