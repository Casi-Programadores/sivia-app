<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SolicitudViatico; 
use Barryvdh\DomPDF\Facade\Pdf;
use Luecano\NumeroALetras\NumeroALetras;
use App\Models\Empleado; 

class PDFController extends Controller
{
    public function generarPDF($id)
    {
        // Cargar datos
        $solicitud = SolicitudViatico::with([
            'empleados.persona', 
            'numeroNotaInterna', 
            'distrito',          
            'localidad',         
            'porcentaje'         
        ])->findOrFail($id);

        // Convertir monto a letras 
        $formatter = new NumeroALetras();
        

        $montoEnLetras = $formatter->toMoney($solicitud->monto_total, 2, 'PESOS', 'CENTAVOS');

        $pdf = Pdf::loadView('pdf.solicitud', compact('solicitud', 'montoEnLetras'))
                  ->setPaper('legal', 'portrait'); 

        return $pdf->stream("solicitud_viatico_{$solicitud->id}.pdf");
    }

    public function generarCertificado($solicitudId, $empleadoId)
    {
        //  Buscamos la solicitud con todas las relaciones necesarias
        $solicitud = SolicitudViatico::with([
            'numeroNotaInterna',
            'distrito',
            'localidad',
            'porcentaje',
            'detalle.resolucion' 
        ])->findOrFail($solicitudId);

        //  Buscamos al empleado específico con sus datos personales y de departamento
        $empleado = Empleado::with(['persona', 'departamento'])
            ->findOrFail($empleadoId);

        //  Generamos la vista
        $pdf = Pdf::loadView('pdf.certificado', compact('solicitud', 'empleado'))
                  ->setPaper('legal', 'portrait'); 

        return $pdf->stream("certificado_viatico_{$empleado->numero_legajo}.pdf");
    }

    public function generarLiquidacion($solicitudId, $empleadoId)
    {
        $solicitud = SolicitudViatico::with([
            'numeroNotaInterna',
            'distrito',
            'localidad',
            'porcentaje',
            'detalle.resolucion', 
            'empleados.departamento' 
        ])->findOrFail($solicitudId);

        $empleado = \App\Models\Empleado::with(['persona', 'clase', 'departamento'])
            ->findOrFail($empleadoId);

        // Importe Diario (Base)
        $importeDiario = $solicitud->monto;
        
        $dias = $solicitud->cantidad_dias;
        
        $porcentajeValor = $solicitud->porcentaje->porcentaje ?? 100;

        // Total Liquidación = (Diario * Días * (Porcentaje/100))
        $totalLiquidacion = ($importeDiario * $dias) * ($porcentajeValor / 100);

        //  Generar PDF
        $pdf = Pdf::loadView('pdf.liquidacion', compact('solicitud', 'empleado', 'importeDiario', 'totalLiquidacion', 'porcentajeValor'))
                  ->setPaper('legal', 'portrait');

        return $pdf->stream("liquidacion_viatico_{$empleado->numero_legajo}.pdf");
    }
}