<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudViatico;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\ReporteLiquidacionesExport;


class ReporteController extends Controller
{
    public function exportarPDF(Request $request)
    {
        //  Recuperar filtros de la URL
        $mes = $request->input('mes', now()->format('Y-m'));
        $empleado_id = $request->input('empleado');
        $destino = $request->input('destino');

        $query = SolicitudViatico::query()
            ->with(['empleados.persona', 'distrito', 'localidad', 'porcentaje', 'detalle', 'numeroNotaInterna'])
            ->whereHas('detalle', function($q) {
                $q->whereIn('estado_solicitud_id', [2]); // Aprobadas
            });

        if ($mes) {
            $fecha = Carbon::createFromFormat('Y-m', $mes);
            $query->whereMonth('created_at', $fecha->month)
                  ->whereYear('created_at', $fecha->year);
        }

        if ($destino) {
            $query->where(function($q) use ($destino) {
                $q->where('provincia', 'like', '%' . $destino . '%')
                  ->orWhereHas('localidad', fn($sq) => $sq->where('nombre_localidades', 'like', '%' . $destino . '%'))
                  ->orWhereHas('distrito', fn($sq) => $sq->where('distrito', 'like', '%' . $destino . '%'));
            });
        }

        if ($empleado_id) {
            $query->whereHas('empleados', function($q) use ($empleado_id) {
                $q->where('empleados.id', $empleado_id);
            });
        }

        $solicitudes = $query->latest()->get();

        // Preparar datos planos para la vista (desglosar empleados)
        $filasReporte = [];
        $totalMontoGlobal = 0;

        foreach ($solicitudes as $sol) {
            $pctValor = $sol->porcentaje->porcentaje ?? 100;
            $montoIndividual = ($sol->monto * $sol->cantidad_dias) * ($pctValor / 100);

            foreach ($sol->empleados as $emp) {
                if ($empleado_id && $emp->id != $empleado_id) continue;

                $totalMontoGlobal += $montoIndividual;

                $filasReporte[] = [
                    'fecha' => $sol->created_at->format('d/m/Y'),
                    'nota'  => $sol->numeroNotaInterna->numero ?? '-',
                    'legajo' => $emp->numero_legajo,
                    'empleado' => $emp->persona->apellido . ', ' . $emp->persona->nombre,
                    'destino' => $sol->provincia ?? ($sol->distrito->distrito ?? '-'),
                    'dias' => $sol->cantidad_dias,
                    'monto' => $montoIndividual
                ];
            }
        }

        // Generar PDF
        $pdf = Pdf::loadView('pdf.reporte-mensual', compact('filasReporte', 'totalMontoGlobal', 'mes'))
                  ->setPaper('A4', 'landscape'); 

        return $pdf->stream('reporte-mensual.pdf');
    }

        public function exportarExcel(Request $request)
    {
        // Capturamos los filtros que vienen de la URL (enviados por Livewire)
        $mes = $request->input('mes', now()->format('Y-m'));
        $empleado_id = $request->input('empleado');
        $destino = $request->input('destino');

        // Generamos la descarga usando la clase Export que creaste
        return Excel::download(
            new ReporteLiquidacionesExport($mes, $empleado_id, $destino), 
            'reporte_liquidaciones_' . $mes . '.xlsx'
        );
    }
}