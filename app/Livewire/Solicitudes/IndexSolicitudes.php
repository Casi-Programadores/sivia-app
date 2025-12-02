<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SolicitudViatico;
use App\Models\Empleado;
use App\Models\EstadoSolicitud;
use Illuminate\Support\Carbon;

class IndexSolicitudes extends Component
{
    use WithPagination;

    // Filtros
    public $search_id = '';     
    public $search_empleado = ''; 
    public $search_destino = '';
    public $filtro_estado = '';
    public $fecha_desde;
    public $fecha_hasta;

    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['search_id', 'search_empleado', 'search_destino', 'filtro_estado', 'fecha_desde', 'fecha_hasta']);
        $this->resetPage();
    }

    public function render()
    {
        $query = SolicitudViatico::query()
            ->with(['empleados.persona', 'distrito', 'localidad', 'numeroNotaInterna', 'detalle.estado']);

        // Filtro por ID o Nota Interna
        if ($this->search_id) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->search_id . '%')
                  ->orWhereHas('numeroNotaInterna', fn($sq) => $sq->where('numero', 'like', '%' . $this->search_id . '%'));
            });
        }

        // 2. Filtro por Empleado
        if ($this->search_empleado) {
            $query->whereHas('empleados', function($q) {
                $q->where('empleados.id', $this->search_empleado);
            });
        }

        // 3. Filtro por Destino
        if ($this->search_destino) {
            $query->where(function($q) {
                $q->where('provincia', 'like', '%' . $this->search_destino . '%')
                  ->orWhereHas('localidad', fn($sq) => $sq->where('nombre_localidades', 'like', '%' . $this->search_destino . '%'))
                  ->orWhereHas('distrito', fn($sq) => $sq->where('distrito', 'like', '%' . $this->search_destino . '%'));
            });
        }

        // 4. Filtro por Fechas (Desde - Hasta)
        if ($this->fecha_desde) {
            $query->whereDate('created_at', '>=', $this->fecha_desde);
        }
        if ($this->fecha_hasta) {
            $query->whereDate('created_at', '<=', $this->fecha_hasta);
        }

        // 5. Filtro por Estado 
        if ($this->filtro_estado) {
            // Si el filtro es "Pendiente" (ID 1), incluimos las que tienen estado 1 O las que no tienen detalle aún
            if ($this->filtro_estado == 1) {
                $query->where(function($q) {
                    $q->whereHas('detalle', fn($sq) => $sq->where('estado_solicitud_id', 1))
                      ->orWhereDoesntHave('detalle');
                });
            } else {
                $query->whereHas('detalle', fn($q) => $q->where('estado_solicitud_id', $this->filtro_estado));
            }
        }

        // Paginación
        $solicitudes = $query->latest()->paginate(10);

        // Procesar estado visual para la tabla
        $solicitudes->getCollection()->transform(function ($solicitud) {
            $estadoId = $solicitud->detalle->estado_solicitud_id ?? 1; // 1 = Pendiente por defecto
            
            $solicitud->estado_nombre = match($estadoId) {
                1 => 'Pendiente',
                2 => 'Aprobada',
                3 => 'Cancelada',
                default => 'Desconocido'
            };
            
            $solicitud->estado_color = match($estadoId) {
                1 => 'orange',
                2 => 'green',
                3 => 'red',
                default => 'gray'
            };

            return $solicitud;
        });

        return view('livewire.solicitudes.index-solicitudes', [
            'solicitudes' => $solicitudes,
            'empleados' => Empleado::with('persona')->get(), // Para el select de filtro
            'estados' => EstadoSolicitud::all(), // Para el select de estado
        ]);
    }
}