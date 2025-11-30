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
        // 1. Cargar datos
        $solicitud = SolicitudViatico::with([
            'empleados.persona', 
            'numeroNotaInterna', 
            'distrito',          
            'localidad',         
            'porcentaje'         
        ])->findOrFail($id);

        // 2. Convertir monto a letras usando el paquete
        $formatter = new NumeroALetras();
        
        // toMoney(valor, decimales, moneda, centavos)
        // Esto generará algo como: "SESENTA Y TRES MIL PESOS 00/100 M.N." o similar según configuración
        // Si quieres el formato exacto "PESOS CON XX/100", el paquete lo hace muy bien por defecto
        $montoEnLetras = $formatter->toMoney($solicitud->monto_total, 2, 'PESOS', 'CENTAVOS');

        // 3. Generar PDF
        $pdf = Pdf::loadView('pdf.solicitud', compact('solicitud', 'montoEnLetras'))
                  ->setPaper('legal', 'portrait'); 

        return $pdf->stream("solicitud_viatico_{$solicitud->id}.pdf");
    }
}