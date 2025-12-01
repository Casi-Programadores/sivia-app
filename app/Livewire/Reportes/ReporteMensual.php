<?php

namespace App\Livewire\Reportes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SolicitudViatico;
use App\Models\Empleado;
use Illuminate\Support\Carbon;

class ReporteMensual extends Component
{
    use WithPagination;

    // Filtros
    public $mes;
    public $empleado_id = '';
    public $destino = '';

    public function mount()
    {
        $this->mes = now()->format('Y-m');
    }

    public function updated($propertyName)
    {
        // Reseteamos a página 1 si cambian filtros
        $this->resetPage(); 
    }

    public function limpiarFiltros()
    {
        $this->empleado_id = ''; 
        $this->destino = '';
        $this->mes = now()->format('Y-m');
        $this->resetPage();
    }

    public function exportar()
    {
        $this->dispatch('notify', 'Generando reporte en Excel...');
    }

    public function render()
    {
        // 1. QUERY BASE (Construcción)
        $query = SolicitudViatico::query()
            ->with(['empleados.persona', 'distrito', 'localidad', 'porcentaje', 'detalle'])
            ->whereHas('detalle', function($q) {
                $q->whereIn('estado_solicitud_id', [2]); // 2 = Aprobada
            });

        // 2. APLICAR FILTROS
        if ($this->mes) {
            $fecha = Carbon::createFromFormat('Y-m', $this->mes);
            $query->whereMonth('created_at', $fecha->month)
                  ->whereYear('created_at', $fecha->year);
        }

        if ($this->destino) {
            $query->where(function($q) {
                $q->where('provincia', 'like', '%' . $this->destino . '%')
                  ->orWhereHas('localidad', fn($sq) => $sq->where('nombre_localidades', 'like', '%' . $this->destino . '%'))
                  ->orWhereHas('distrito', fn($sq) => $sq->where('distrito', 'like', '%' . $this->destino . '%'));
            });
        }

        if ($this->empleado_id) {
            $query->whereHas('empleados', function($q) {
                $q->where('empleados.id', $this->empleado_id);
            });
        }


        $datosParaEstadisticas = (clone $query)->get();

        $resultados = $query->latest()->paginate(5);

        
        $totalLiquidaciones = 0;
        $totalMonto = 0;
        $empleadosUnicos = collect();

        foreach ($datosParaEstadisticas as $sol) {
            // Fórmula matemática por persona
            $pctValor = $sol->porcentaje->porcentaje ?? 100;
            $montoIndividual = ($sol->monto * $sol->cantidad_dias) * ($pctValor / 100);

            foreach ($sol->empleados as $emp) {
                // Si hay filtro de empleado, sumamos solo si coincide
                if ($this->empleado_id && $emp->id != $this->empleado_id) {
                    continue; 
                }

                $totalLiquidaciones++; 
                $totalMonto += $montoIndividual; 
                $empleadosUnicos->push($emp->id);
            }
        }

        if ($this->empleado_id) {
            $resultados->getCollection()->transform(function ($solicitud) {
                $empleadosFiltrados = $solicitud->empleados->filter(function ($emp) {
                    return $emp->id == $this->empleado_id;
                });
                $solicitud->setRelation('empleados', $empleadosFiltrados);
                return $solicitud;
            });
        }

        return view('livewire.reportes.reporte-mensual', [
            'resultados' => $resultados,          
            'totalLiquidaciones' => $totalLiquidaciones, 
            'totalMonto' => $totalMonto,                 
            'totalEmpleados' => $empleadosUnicos->unique()->count(),
            'todosEmpleados' => Empleado::with('persona')->get()
        ]);
    }
}