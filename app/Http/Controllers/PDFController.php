<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SolicitudViatico; 
use Barryvdh\DomPDF\Facade\Pdf;
use Luecano\NumeroALetras\NumeroALetras; 

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
}