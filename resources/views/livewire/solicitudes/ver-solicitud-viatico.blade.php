<div> {{-- 1. APERTURA DEL ROOT DIV (OBLIGATORIO EN LIVEWIRE) --}}

    {{-- ESTILOS: Deben estar DENTRO del div principal --}}
    <style>
        .hoja-a4 {
            width: 21cm;
            min-height: 29.7cm;
            padding: 1.5cm;
            background: white;
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            color: black;
            font-family: Arial, sans-serif;
            position: relative;
        }

        /* Estilos de Impresión */
        @media print {
            body * { visibility: hidden; } /* Ocultar todo */
            .hoja-a4, .hoja-a4 * { visibility: visible; } /* Mostrar solo la hoja */
            
            .hoja-a4 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0 !important;
                padding: 1cm !important; /* Margen físico */
                box-shadow: none !important;
                border: none !important;
            }
            
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>

    {{-- CONTENIDO VISUAL --}}
    <div class="w-full bg-gray-100 p-4 md:p-8 overflow-y-auto font-sans">
        
        <!-- BOTONERA (Se oculta al imprimir) -->
        <div class="max-w-[21cm] mx-auto mb-6 flex justify-between items-center no-print">
            <a href="#" class="text-blue-600 hover:text-blue-800 font-bold flex items-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Volver al listado
            </a>
            <button onclick="window.print()" class="bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-gray-700 font-bold flex items-center transition transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                IMPRIMIR DOCUMENTO
            </button>
        </div>

        <!-- HOJA A4 (Diseño idéntico a la foto) -->
        <div class="hoja-a4">
            
            <!-- ENCABEZADO CON LOGOS -->
            <div class="flex justify-between items-start mb-6 px-4">
                <!-- Logo Izq -->
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-500 border border-gray-300">
                    LOGO
                </div>
                
                <!-- Texto Central -->
                <div class="text-center flex-1 mx-4">
                    <div class="border border-black p-2 inline-block mb-2 w-64">
                        <p class="text-[10px] font-bold uppercase">Dirección Provincial de Vialidad</p>
                        <p class="text-lg font-bold my-1">{{ now()->format('d M Y') }}</p> {{-- Fecha actual simulada para Mesa --}}
                        <p class="text-[9px] uppercase">Mesa Gral. de Entrada</p>
                        <div class="text-[10px] flex justify-between px-4">
                            <span>Letra ...</span> <span>N° .......</span>
                        </div>
                    </div>
                    
                    <h3 class="font-bold text-lg uppercase mt-4">NOTA INTERNA Nº <span class="text-xl">{{ $solicitud->numeroNotaInterna->numero ?? '____' }}</span></h3>
                    <h1 class="font-extrabold text-xl uppercase mt-2">SOLICITUD DE COMISIÓN DE SERVICIOS</h1>
                    <p class="mt-2 font-bold uppercase text-xs">
                        FORMOSA, {{ $solicitud->created_at->format('d') }} de {{ \Carbon\Carbon::parse($solicitud->created_at)->locale('es')->monthName }} de {{ $solicitud->created_at->format('Y') }}
                    </p>
                </div>

                <!-- Logo Der -->
                <div class="w-20 h-20"></div> 
            </div>

            <!-- TEXTO INTRODUCTORIO -->
            <p class="text-xs text-justify mb-4 px-2 font-medium">
                Se solicita gestionar ante la Superioridad la autorización para Comisión de Servicios de los agentes mencionados seguidamente:
            </p>

            <!-- TABLA DE EMPLEADOS (Rejilla exacta) -->
            <div class="border-2 border-black mb-6">
                <table class="w-full text-[10px] text-center border-collapse">
                    <thead>
                        <tr class="border-b border-black bg-gray-100">
                            <th class="border-r border-black py-1 w-1/3">Nombre y Apellido</th>
                            <th class="border-r border-black py-1">N° Leg.</th>
                            <th class="border-r border-black py-1">Asiento</th>
                            <th class="border-r border-black py-1 leading-tight">Cant.<br>días</th>
                            <th class="border-r border-black py-1">%</th>
                            <th class="border-r border-black py-1">Monto</th>
                            <th class="border-r border-black py-1">Destino</th>
                            <th class="py-1 leading-tight">Fecha<br>salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cantidad = $solicitud->empleados->count();
                            $montoInd = $cantidad > 0 ? ($solicitud->monto_total / $cantidad) : 0;
                        @endphp

                        @forelse($solicitud->empleados as $empleado)
                        <tr class="border-b border-black font-medium">
                            <td class="border-r border-black py-1 px-2 text-left uppercase">{{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}</td>
                            <td class="border-r border-black py-1">{{ $empleado->numero_legajo }}</td>
                            <td class="border-r border-black py-1">Sede</td>
                            <td class="border-r border-black py-1">{{ $solicitud->cantidad_dias }}</td>
                            <td class="border-r border-black py-1">{{ $solicitud->porcentaje->porcentaje ?? 100 }}</td>
                            <td class="border-r border-black py-1">$ {{ number_format($montoInd, 2, ',', '.') }}</td>
                            <td class="border-r border-black py-1 uppercase text-[9px]">
                                {{ $solicitud->provincia ? Str::limit($solicitud->provincia, 10) : ($solicitud->distrito->distrito ?? '-') }}
                            </td>
                            <td class="py-1">{{ $solicitud->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr class="border-b border-black"><td colspan="8" class="py-2 italic">Sin agentes</td></tr>
                        @endforelse

                        {{-- Relleno visual --}}
                        @for($i=0; $i < (3 - $cantidad); $i++)
                        <tr class="border-b border-black h-5">
                            <td class="border-r border-black"></td><td class="border-r border-black"></td><td class="border-r border-black"></td><td class="border-r border-black"></td><td class="border-r border-black"></td><td class="border-r border-black"></td><td class="border-r border-black"></td><td></td>
                        </tr>
                        @endfor
                        
                        <tr class="font-bold bg-gray-100">
                            <td colspan="5" class="border-r border-black text-right pr-2 py-1">Total</td>
                            <td class="border-r border-black py-1">$ {{ number_format($solicitud->monto_total, 2, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- DATOS DESCRIPTIVOS -->
            <div class="space-y-4 px-2 text-[10px] font-bold uppercase mb-8">
                <div class="flex items-end">
                    <span class="mr-2 whitespace-nowrap">SON PESOS:</span>
                    <span id="monto-en-letras" class="border-b border-dotted border-black w-full pl-2">Calculando...</span>
                </div>
                
                <div class="flex items-end">
                    <span class="mr-2 whitespace-nowrap">OBJETO DE LA COMISIÓN:</span>
                    <span class="border-b border-dotted border-black w-full pl-2 leading-tight">
                        {{ $solicitud->objeto_comision }} - 
                        LOC: {{ $solicitud->localidad->nombre_localidades ?? 'VARIAS' }} - 
                        DIST: {{ $solicitud->distrito->distrito ?? 'VARIOS' }}.-
                    </span>
                </div>

                <div class="flex items-end">
                    <span class="mr-2 whitespace-nowrap">OBSERVACIONES:</span>
                    <span class="border-b border-dotted border-black w-full pl-2">
                        {{ $solicitud->observacion ?? '------------------------------------------------' }}
                    </span>
                </div>
            </div>

            <!-- FIRMAS -->
            <div class="flex justify-between mt-12 px-10 mb-8">
                <div class="text-center w-1/3">
                    <div class="border-b border-black mb-1 w-full mx-auto" style="height: 30px;"></div> {{-- Espacio para garabato --}}
                    <p class="text-[9px] font-bold">VºBº - Ingeniero Jefe</p>
                    <p class="text-[8px] text-gray-500">A/C INGENIERO JEFE</p>
                </div>
                <div class="text-center w-1/3">
                    <div class="border-b border-black mb-1 w-full mx-auto" style="height: 30px;"></div>
                    <p class="text-[9px] font-bold">Firma del Responsable</p>
                    <p class="text-[8px] text-gray-500">Jefe Dpto. Ingeniería Vial</p>
                </div>
            </div>

            <!-- PIE DE PÁGINA LEGAL -->
            <div class="border-t-2 border-black pt-2 px-2">
                <p class="text-center font-bold text-[10px] uppercase mb-2">
                    DIRECCIÓN PROVINCIAL DE VIALIDAD, ......... de ......................................... de 2025.-
                </p>
                
                <div class="text-[9px] text-justify leading-tight space-y-2 font-medium">
                    <p>
                        <span class="font-bold">VISTO:</span> estas actuaciones por las que se tramita la realización de una Comisión Oficial de Servicios solicitada por el Jefe del <strong>DEPARTAMENTO INGENIERÍA VIAL</strong>, y;
                    </p>
                    <p>
                        <span class="font-bold">CONSIDERANDO:</span> que el procedimiento utilizado se ajusta al régimen implantado en la Repartición y demás Normas aplicables para el efecto.
                    </p>
                    <p class="text-center font-bold mt-2">
                        EL ADMINISTRADOR GENERAL DE LA DIRECCIÓN PROVINCIAL DE VIALIDAD<br>
                        RESUELVE
                    </p>
                    <p>
                        Ratificar lo actuado para la realización de la Comisión Oficial de Servicios, tramitada en autos por el Jefe del <strong>DEPARTAMENTO INGENIERÍA VIAL</strong>, conforme a las constancias precedentes. Regístrase y dése intervención a quienes corresponda, cumplido ARCHÍVESE.-
                    </p>
                </div>

                <!-- SELLO RESOLUCIÓN -->
                <div class="flex justify-between items-end mt-6">
                    <div class="font-bold text-xs">
                        RESOLUCIÓN Nº <span class="text-xl ml-2 text-gray-300 tracking-widest">3337</span>
                    </div>
                    <div class="text-center w-1/3">
                        <div class="border-b border-black mb-1 w-full mx-auto"></div>
                        <p class="text-[9px]">Administrador General</p>
                        <p class="text-[8px]">Dirección Provincial de Vialidad</p>
                    </div>
                </div>
            </div>

        </div> <!-- Fin Hoja A4 -->
    </div>

    {{-- SCRIPT JS: También DENTRO del root div --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monto = {{ $solicitud->monto_total }};
            document.getElementById('monto-en-letras').innerText = numeroALetras(monto) + " .---";
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

</div> {{-- 2. CIERRE DEL ROOT DIV --}}