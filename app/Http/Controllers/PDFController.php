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

        // Convertir monto a letras usando el paquete
        $formatter = new NumeroALetras();
        

        $montoEnLetras = $formatter->toMoney($solicitud->monto_total, 2, 'PESOS', 'CENTAVOS');

        // Generar PDF
        $pdf = Pdf::loadView('pdf.solicitud', compact('solicitud', 'montoEnLetras'))
                  ->setPaper('legal', 'portrait'); 

        return $pdf->stream("solicitud_viatico_{$solicitud->id}.pdf");
    }

       public function generarCertificado($solicitudId, $empleadoId)
    {
        // 1. Buscamos la solicitud con todas las relaciones necesarias
        // Incluimos 'detalle.resolucion' para obtener el número de resolución que cargaste en el paso anterior
        $solicitud = SolicitudViatico::with([
            'numeroNotaInterna',
            'distrito',
            'localidad',
            'porcentaje',
            'detalle.resolucion' 
        ])->findOrFail($solicitudId);

        // 2. Buscamos al empleado específico con sus datos personales y de departamento
        $empleado = Empleado::with(['persona', 'departamento'])
            ->findOrFail($empleadoId);

        // 3. Generamos la vista
        $pdf = Pdf::loadView('pdf.certificado', compact('solicitud', 'empleado'))
                  ->setPaper('legal', 'portrait'); 

        return $pdf->stream("certificado_viatico_{$empleado->numero_legajo}.pdf");
    }
}