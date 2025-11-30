<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SolicitudViatico; 
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter; 

class PDFController extends Controller
{
    public function generarPDF($id)
    {
        $solicitud = SolicitudViatico::with([
            'empleados.persona', // Para nombre y apellido
            'numeroNotaInterna', // Para el número de nota
            'distrito',          // Para el destino
            'localidad',         // Para el destino
            'porcentaje'         // Para el % de liquidación
        ])->findOrFail($id);

        $montoEnLetras = $this->numeroALetras($solicitud->monto_total);

        // 3. Generar el PDF
        // Usamos 'legal' para tamaño Oficio. 
        $pdf = Pdf::loadView('pdf.solicitud', compact('solicitud', 'montoEnLetras'))
                  ->setPaper('legal', 'portrait'); 

        return $pdf->stream("solicitud_viatico_{$solicitud->id}.pdf");
    }

    /**
     * Función auxiliar para convertir números a letras en PHP
     */
    private function numeroALetras($numero)
    {
        if (class_exists('NumberFormatter')) {
            $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
            return mb_strtoupper($formatter->format($numero));
        }

        return $this->convertirManual($numero);
    }

    private function convertirManual($num)
    {
        $unidad = ['','UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
        $decena = ['','DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
        // ... (Lógica simplificada para el ejemplo)
        
        return "PESOS CONVERTIDOS MANUALMENTE (Instalar extensión intl para automático)";
    }
}

