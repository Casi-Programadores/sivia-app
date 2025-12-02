<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SolicitudViatico;
use App\Models\EstadoSolicitud;
use App\Models\DetalleSolicitudViatico;

class UltimasSolicitudesTabla extends Component
{
    use WithPagination;

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
        // Si hay una solicitud seleccionada, redirigimos a la vista de certificar
        if ($this->solicitudSeleccionadaId) {
            return redirect()->route('solicitudes.certificar', $this->solicitudSeleccionadaId);
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
        $estadoCancelado = EstadoSolicitud::where('id', 3)->orWhere('nombre_estado', 'Rechazada')->first();

        if ($estadoCancelado && $this->solicitudSeleccionadaId) {
            
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
        // 3. Usamos paginate(5) en lugar de take(5)->get()
        $solicitudes = SolicitudViatico::with(['distrito', 'localidad', 'numeroNotaInterna'])
            ->latest()
            ->paginate(5); // Paginación real de 5 por página

        // Procesamos el estado para cada item de la página actual
        $solicitudes->getCollection()->transform(function ($solicitud) {
            $ultimoDetalle = DetalleSolicitudViatico::where('solicitud_viatico_id', $solicitud->id)
                ->latest()
                ->first();
                
            $solicitud->estado_actual = $ultimoDetalle ? $ultimoDetalle->estado_solicitud_id : 1; 
            
            $solicitud->nombre_estado = match($solicitud->estado_actual) {
                1 => 'Pendiente',
                2 => 'Aprobada',
                3 => 'Cancelada',
                default => 'En Proceso'
            };
            return $solicitud;
        });

        return view('livewire.solicitudes.ultimas-solicitudes-tabla', [
            'solicitudes' => $solicitudes
        ]);
    }
}