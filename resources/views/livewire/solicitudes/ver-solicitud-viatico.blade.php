<div class="w-full bg-gray-100 p-4 md:p-8 overflow-y-auto">
    
    <!-- ESTILOS ESPECÍFICOS PARA ESTE DOCUMENTO -->
    <style>
        /* Estilos de la hoja para ver en PANTALLA (Simulación A4) */
        .hoja-a4 {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            background: white;
            
            /* Dimensiones A4 */
            width: 100%;
            max-width: 21cm; 
            min-height: 29.7cm;
            
            /* Centrado en pantalla */
            margin: 0 auto;
            padding: 2cm;
            
            /* Sombra para efecto de papel */
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            position: relative;
        }

        /* Utilidades internas del documento */
        .doc-header { text-align: center; margin-bottom: 30px; }
        .doc-header-logos { display: flex; justify-content: center; align-items: center; gap: 40px; margin-bottom: 15px; }
        .doc-header-text { font-size: 8pt; color: #333; line-height: 1.2; }
        
        .doc-title-section { text-align: center; margin: 20px 0 30px 0; }
        .doc-nota-number { font-weight: bold; font-size: 11pt; margin-bottom: 5px; }
        .doc-main-title { font-weight: bold; font-size: 12pt; margin-bottom: 10px; text-decoration: underline; }
        .doc-location-date { font-size: 11pt; margin-bottom: 20px; font-weight: bold; }
        
        .doc-intro-text { text-align: justify; margin-bottom: 20px; font-size: 11pt; }
        
        /* Tabla personalizada */
        .doc-table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 9pt; }
        .doc-table th, .doc-table td { border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle; }
        .doc-table th { background-color: #f0f0f0; font-weight: bold; text-transform: uppercase; }
        .doc-table td.text-left { text-align: left; }
        .doc-table tfoot td { font-weight: bold; background-color: #f0f0f0; }

        .doc-section-label { font-weight: bold; margin-top: 15px; }
        .doc-observation-box { min-height: 40px; border-bottom: 1px dotted #000; margin-bottom: 20px; }
        
        .doc-signatures { display: flex; justify-content: space-between; margin-top: 60px; margin-bottom: 20px; }
        .doc-signature-line { text-align: center; width: 40%; border-top: 1px solid #000; padding-top: 5px; font-size: 10pt; }

        .doc-footer-section { margin-top: 30px; text-align: center; font-size: 10pt; border-top: 1px solid #ccc; padding-top: 10px; }
        
        .doc-approval-text { text-align: justify; font-size: 9pt; line-height: 1.3; margin-top: 20px; border-top: 2px solid #000; padding-top: 20px; }
        
        .doc-resolution-box { margin-top: 40px; font-weight: bold; font-size: 12pt; }

        /* ESTILOS DE IMPRESIÓN (LO MÁS IMPORTANTE) */
        @media print {
            /* Ocultar todo lo que no sea la hoja (Sidebar, Header de la app, botones) */
            body * {
                visibility: hidden; 
            }
            
            /* Hacer visible solo la hoja y su contenido */
            .hoja-a4, .hoja-a4 * {
                visibility: visible;
            }

            /* Posicionar la hoja ocupando todo el papel */
            .hoja-a4 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 1.5cm !important; /* Margen físico de la impresora */
                box-shadow: none !important;
                border: none !important;
                background: white !important;
            }

            /* Ocultar elementos marcados como no-print dentro de la hoja */
            .no-print { display: none !important; }
            
            /* Forzar fondo blanco y texto negro */
            body { background: white !important; }
        }
    </style>

    <!-- BOTONERA SUPERIOR (Fuera de la hoja, no se imprime) -->
    <div class="max-w-[21cm] mx-auto mb-6 flex justify-between items-center no-print">
        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
            ← Volver al listado
        </a>
        <button onclick="window.print()" class="bg-gray-800 text-white px-5 py-2 rounded shadow hover:bg-gray-700 font-bold flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            IMPRIMIR
        </button>
    </div>

    <!-- LA HOJA A4 (Contenedor Principal) -->
    <div class="hoja-a4">
        
        <!-- ENCABEZADO CON LOGOS -->
        <div class="doc-header">
            <div class="doc-header-logos">
                <!-- Logos simulados con círculos grises (Reemplazar con <img> real) -->
                <!-- <img src="{{ asset('img/logo_vialidad.png') }}" style="height: 60px;"> -->
                <div style="width: 50px; height: 50px; background: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 8px;">LOGO 1</div>
                
                <div class="doc-header-text">
                    <strong>DIRECCIÓN PROVINCIAL DE VIALIDAD</strong><br>
                    Julio 1681 - Tel 03717 - 437003/04<br>
                    C.P. 3600 - FORMOSA
                </div>
                
                <div style="width: 50px; height: 50px; background: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 8px;">LOGO 2</div>
            </div>
        </div>

        <!-- TÍTULO PRINCIPAL -->
        <div class="doc-title-section">
            <div class="doc-nota-number">
                NOTA INTERNA Nº {{ $solicitud->numeroNotaInterna->numero ?? '____' }}
            </div>
            <div class="doc-main-title">
                SOLICITUD DE COMISIÓN DE SERVICIOS
            </div>
            <div class="doc-location-date uppercase">
                FORMOSA, {{ $solicitud->created_at->format('d') }} DE {{ \Carbon\Carbon::parse($solicitud->created_at)->locale('es')->monthName }} DE {{ $solicitud->created_at->format('Y') }}
            </div>
        </div>

        <!-- TEXTO INTRODUCTORIO -->
        <div class="doc-intro-text">
            Se solicita gestionar ante la Superioridad la autorización para Comisión de Servicios de los agentes mencionados seguidamente:
        </div>

        <!-- TABLA DE DATOS DEL PERSONAL -->
        <table class="doc-table">
            <thead>
                <tr>
                    <th width="35%">NOMBRE Y APELLIDO</th>
                    <th>Nº LEG</th>
                    <th>ASIENTO</th>
                    <th>CANT.<br>DÍAS</th>
                    <th>%</th>
                    <th>MONTO</th>
                    <th>DESTINO</th>
                    <th>FECHA<br>SALIDA</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cantidadPersonas = $solicitud->empleados->count();
                    $montoIndividual = $cantidadPersonas > 0 ? ($solicitud->monto_total / $cantidadPersonas) : 0;
                @endphp

                @forelse($solicitud->empleados as $empleado)
                <tr>
                    <td class="text-left uppercase">{{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}</td>
                    <td>{{ $empleado->numero_legajo }}</td>
                    <td>SEDE</td> {{-- Fijo según imagen --}}
                    <td>{{ $solicitud->cantidad_dias }}</td>
                    <td>{{ $solicitud->porcentaje->porcentaje ?? 100 }}</td>
                    <td>$ {{ number_format($montoIndividual, 2, ',', '.') }}</td>
                    <td class="uppercase text-xs">
                        @if($solicitud->provincia)
                            {{ Str::limit($solicitud->provincia, 12) }}
                        @else
                            {{ $solicitud->distrito->distrito ?? '-' }}
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($solicitud->created_at)->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="py-4 text-center italic">Sin personal asignado</td></tr>
                @endforelse

                <!-- Relleno para mantener estructura si hay pocos -->
                @for($i = 0; $i < (3 - $cantidadPersonas); $i++)
                <tr style="height: 25px;">
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; border-right: none;">TOTAL</td>
                    <td style="border-left: none;">$ {{ number_format($solicitud->monto_total, 2, ',', '.') }}</td>
                    <td colspan="2" style="background: #fff; border: none;"></td>
                </tr>
            </tfoot>
        </table>

        <!-- DATOS COMPLEMENTARIOS -->
        <div style="margin: 20px 0; font-size: 10pt;">
            <strong>SON PESOS:</strong> <span id="monto-en-letras" class="uppercase">---</span> .---
        </div>

        <div style="margin: 15px 0; font-size: 10pt; line-height: 1.5;">
            <strong>OBJETO DE LA COMISIÓN:</strong> 
            <span class="uppercase">{{ $solicitud->objeto_comision }}</span> 
            - LOCALIDAD: <span class="uppercase">{{ $solicitud->localidad->nombre_localidades ?? 'VARIAS' }}</span>
            - DISTRITO: <span class="uppercase">{{ $solicitud->distrito->distrito ?? 'VARIOS' }}</span>.-
        </div>

        <div style="margin: 15px 0; font-size: 10pt;">
            <strong>OBSERVACIONES:</strong> {{ $solicitud->observacion ?? '--------------------------------' }}
        </div>

        <!-- FIRMAS -->
        <div class="doc-signatures">
            <div class="doc-signature-line">
                VºBº - INGENIERO JEFE
            </div>
            <div class="doc-signature-line">
                FIRMA DEL SOLICITANTE
            </div>
        </div>
        
        <br><br>

        <!-- BLOQUE RESOLUCIÓN (INFERIOR) -->
        <div class="doc-approval-text">
            <p><strong>DIRECCIÓN PROVINCIAL DE VIALIDAD,</strong> .......... de ......................................... de 2025.-</p>
            
            <p style="margin-top: 10px;">
                <strong>VISTO:</strong> estas actuaciones por las que se tramita la realización de una Comisión Oficial 
                de Servicios solicitada por el Jefe del <strong>DEPARTAMENTO INGENIERÍA VIAL</strong>, y;
            </p>
            <p>
                <strong>CONSIDERANDO:</strong> que el procedimiento utilizado se ajusta al régimen implantado en 
                la Repartición y demás Normas aplicables para el efecto.
            </p>
            
            <p style="margin-top: 10px; text-align: center;">
                EL ADMINISTRADOR GENERAL DE LA DIRECCIÓN PROVINCIAL DE VIALIDAD<br>
                <strong>RESUELVE</strong>
            </p>
            
            <p style="margin-top: 10px;">
                Ratificar lo actuado para la realización de la Comisión Oficial de Servicios, tramitada 
                en autos por el Jefe del <strong>DEPARTAMENTO INGENIERÍA VIAL</strong>, conforme a las constancias precedentes.
                Regístrase y dése intervención a quienes corresponda, cumplido ARCHÍVESE.-
            </p>
        </div>

        <div class="doc-resolution-box">
            RESOLUCIÓN Nº ______________
        </div>

    </div>

    <!-- SCRIPT JS PARA MONTO EN LETRAS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monto = {{ $solicitud->monto_total }};
            document.getElementById('monto-en-letras').innerText = numeroALetras(monto);
        });

        function numeroALetras(num) {
            const unidades = ['', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
            const decenas = ['', 'DIEZ', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
            const diez_x = ['', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
            const centenas = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];
            
            num = parseInt(num);
            if (num === 0) return 'CERO';
            
            let texto = '';

            if (num >= 1000) {
                let miles = Math.floor(num / 1000);
                texto += (miles === 1 ? 'MIL ' : numeroALetras(miles) + ' MIL ');
                num %= 1000;
            }
            if (num >= 100) {
                let c = Math.floor(num / 100);
                texto += (num === 100 ? 'CIEN ' : centenas[c] + ' ');
                num %= 100;
            }
            if (num > 0) {
                if (num < 10) texto += unidades[num];
                else if (num < 20) texto += diez_x[num - 10];
                else {
                    let d = Math.floor(num / 10), u = num % 10;
                    texto += decenas[d];
                    if (u > 0) texto += (d === 2 ? 'I' : ' Y ') + unidades[u];
                }
            }
            return texto.trim();
        }
    </script>

</div>