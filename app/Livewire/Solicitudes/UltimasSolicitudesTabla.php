<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\SolicitudViatico;
use App\Models\EstadoSolicitud;
use App\Models\DetalleSolicitudViatico;

class UltimasSolicitudesTabla extends Component
{
    public $solicitudSeleccionadaId = null;
    public $mostrarModalAprobar = false;
    public $mostrarModalCancelar = false;

    // --- ACCIÓN: APROBAR ---

    public function confirmarAprobacion($id)
    {
        $this->solicitudSeleccionadaId = $id;
        $this->mostrarModalAprobar = true;
    }

    public function aprobarSolicitud()
    {
        $estadoAprobado = EstadoSolicitud::where('nombre_estado', 'Aprobada')->first();

        if ($estadoAprobado && $this->solicitudSeleccionadaId) {
            
            DetalleSolicitudViatico::updateOrCreate(
                ['solicitud_viatico_id' => $this->solicitudSeleccionadaId], // Busca por este ID
                [
                    'estado_solicitud_id' => $estadoAprobado->id, // Actualiza el estado
                    // Mantenemos mesa y resolución en null o como estén si no los tocas
                ]
            );
        }

        $this->cerrarModales();
    }

    // --- ACCIÓN 2: CANCELAR ---

    public function confirmarCancelacion($id)
    {
        $this->solicitudSeleccionadaId = $id;
        $this->mostrarModalCancelar = true;
    }

    public function cancelarSolicitud()
    {
        // Asumimos que "Cancelada" o "Rechazada" es el ID o nombre correcto
        $estadoCancelado = EstadoSolicitud::where('id', 3)->orWhere('nombre_estado', 'Rechazada')->first();

        if ($estadoCancelado && $this->solicitudSeleccionadaId) {
            
            // CORRECCIÓN: Usamos updateOrCreate
            DetalleSolicitudViatico::updateOrCreate(
                ['solicitud_viatico_id' => $this->solicitudSeleccionadaId], // Busca por este ID
                [
                    'estado_solicitud_id' => $estadoCancelado->id // Cambia el estado a Cancelado
                ]
            );
        }

        $this->cerrarModales();
    }

    public function cerrarModales()
    {
        $this->mostrarModalAprobar = false;
        $this->mostrarModalCancelar = false;
        $this->solicitudSeleccionadaId = null;
    }

    public function render()
    {
        // ... (El resto del render queda igual que antes)
        $solicitudes = SolicitudViatico::with(['distrito', 'localidad', 'numeroNotaInterna'])
            ->latest()
            ->take(5)
            ->get();

        foreach ($solicitudes as $solicitud) {
            // Buscamos el detalle asociado
            $detalle = DetalleSolicitudViatico::where('solicitud_viatico_id', $solicitud->id)->first();
                
            $solicitud->estado_actual = $detalle ? $detalle->estado_solicitud_id : 1; 
            
            // Ajusta estos IDs según tu tabla 'estados_solicitudes'
            $solicitud->nombre_estado = match($solicitud->estado_actual) {
                1 => 'Pendiente',
                2 => 'Aprobada',
                3 => 'Cancelada', // O 'Rechazada'
                default => 'En Proceso'
            };
        }

        return view('livewire.solicitudes.ultimas-solicitudes-tabla', [
            'solicitudes' => $solicitudes
        ]);
    }
}