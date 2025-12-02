<?php

namespace App\Exports;

use App\Models\SolicitudViatico;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Carbon;

class ReporteLiquidacionesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $mes;
    protected $empleado_id;
    protected $destino;

    // Recibimos los filtros en el constructor
    public function __construct($mes, $empleado_id, $destino)
    {
        $this->mes = $mes;
        $this->empleado_id = $empleado_id;
        $this->destino = $destino;
    }

public function collection()
    {
        // 1. Consulta Base 
        $query = SolicitudViatico::query()
            ->with(['empleados.persona', 'distrito', 'localidad', 'porcentaje', 'detalle', 'numeroNotaInterna'])
            ->whereHas('detalle', function($q) {
                $q->whereIn('estado_solicitud_id', [2]); // Solo aprobadas
            });

        // Filtros
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

        $solicitudes = $query->latest()->get();

        // Procesamiento de Datos
        $filas = collect();
        $totalGeneral = 0; // Acumulador para el total final

        foreach ($solicitudes as $sol) {
            // Cálculo matemático individual
            $pctValor = $sol->porcentaje->porcentaje ?? 100;
            $montoIndividual = ($sol->monto * $sol->cantidad_dias) * ($pctValor / 100);

            foreach ($sol->empleados as $emp) {
                if ($this->empleado_id && $emp->id != $this->empleado_id) continue;

                // Sumamos al gran total
                $totalGeneral += $montoIndividual;

                // Agregamos la fila normal
                $filas->push([
                    'fecha'      => $sol->created_at->format('d/m/Y'),
                    'nota'       => $sol->numeroNotaInterna->numero ?? '-',
                    'resolucion' => $sol->detalle->resolucion->numero_resolucion ?? '-',
                    'legajo'     => $emp->numero_legajo,
                    'agente'     => $emp->persona->apellido . ', ' . $emp->persona->nombre,
                    'destino'    => $sol->provincia ?? ($sol->distrito->distrito ?? '-'),
                    'dias'       => $sol->cantidad_dias,
                    'monto'      => $montoIndividual, // Pasamos el número puro para que Excel pueda sumar si el usuario quiere
                ]);
            }
        }

        //  Fila de TOTAL al final
        // Dejamos vacías las columnas de texto para que el total quede alineado a la derecha
        $filas->push([
            '',               // Fecha
            '',               // Nota
            '',               // Resolución
            '',               // Legajo
            '',               // Agente
            '',               // Destino
            'TOTAL GENERAL',  // Columna Días (texto)
            $totalGeneral,    // Columna Monto (valor final)
        ]);

        return $filas;
    }

    public function headings(): array
    {
        return [
            'FECHA',
            'NOTA Nº',
            'RESOLUCIÓN',
            'LEGAJO',
            'AGENTE',
            'DESTINO',
            'DÍAS',
            'MONTO LIQUIDADO',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Obtenemos el número de la última fila (la del total)
        $ultimaFila = $sheet->getHighestRow();

        return [
            // Estilo del Encabezado (Fila 1)
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '162953']]
            ],
            
            // Estilo de la Fila de Total (Última fila)
            $ultimaFila => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E0E0E0']] 
            ],
        ];
    }
}