<div>
    {{-- CONTENEDOR PRINCIPAL: Tarjeta estilo Dashboard --}}
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8 font-sans">

        {{-- 1. ENCABEZADO --}}
        <div class="mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-sm text-gray-500 uppercase tracking-wide font-semibold">Solicitud</h2>
            <div class="text-3xl font-bold text-blue-900">
                {{ $solicitud->id ?? '10' }} {{-- O el ID que corresponda --}}
            </div>
        </div>

        {{-- 2. GRILLA DE DATOS (2 Columnas) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12 mb-8">

            {{-- Fila 1 --}}
            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Número de Nota Interna</label>
                <div class="text-gray-800 text-lg font-medium">
                    {{ $solicitud->numeroNotaInterna->numero ?? '001' }}
                </div>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Porcentaje</label>
                <div class="text-gray-800 text-lg font-medium">
                    {{ $solicitud->porcentaje->porcentaje ?? '100' }}%
                </div>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>

            {{-- Fila 2 --}}
            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Cantidad de Días</label>
                <div class="text-gray-800 text-lg font-medium">
                    {{ $solicitud->cantidad_dias }}
                </div>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Monto Individual</label>
                @php
                    $cantidad = $solicitud->empleados->count();
                    $montoInd = $cantidad > 0 ? ($solicitud->monto_total / $cantidad) : 0;
                @endphp
                <div class="text-gray-800 text-lg font-medium">
                    $ {{ number_format($montoInd, 2, ',', '.') }}
                </div>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>

            {{-- Fila 3: Fechas --}}
            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Fecha de Salida</label>
                <div class="text-gray-800 text-lg font-medium">
                    {{ $solicitud->created_at->format('d/m/Y') }}
                </div>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Fecha de Fin</label>
                <div class="text-gray-800 text-lg font-medium">
                    {{-- {{ \Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y') }} --}}
            
                </div>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>

        </div>

        {{-- 3. SECCIÓN DESTINO (3 Columnas internas) --}}
        <div class="mb-8">
            <h3 class="text-sm font-semibold text-gray-600 mb-4">Destino</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <span class="block text-xs text-gray-400">Provincia</span>
                    <span class="text-gray-800 font-medium">{{ $solicitud->provincia ?? 'Formosa' }}</span>
                    <div class="h-px bg-gray-200 mt-1 w-full"></div>
                </div>
                <div>
                    <span class="block text-xs text-gray-400">Distrito</span>
                    <span class="text-gray-800 font-medium">{{ $solicitud->distrito->distrito ?? '-' }}</span>
                    <div class="h-px bg-gray-200 mt-1 w-full"></div>
                </div>
                <div>
                    <span class="block text-xs text-gray-400">Localidad</span>
                    <span class="text-gray-800 font-medium">{{ $solicitud->localidad->nombre_localidades ?? '-' }}</span>
                    <div class="h-px bg-gray-200 mt-1 w-full"></div>
                </div>
            </div>
        </div>

        {{-- 4. LISTA DE EMPLEADOS --}}
        <div class="mb-8">
            <label class="block text-xs font-medium text-gray-400 uppercase mb-2">Empleados Asignados</label>
            <ul class="list-disc list-inside space-y-1">
                @forelse($solicitud->empleados as $empleado)
                    <li class="text-gray-700 font-medium">
                        {{ $empleado->persona->nombre }} {{ $empleado->persona->apellido }}
                    </li>
                @empty
                    <li class="text-gray-400 italic">Sin empleados asignados</li>
                @endforelse
            </ul>
            <div class="h-px bg-gray-200 mt-4 w-full"></div>
        </div>

        {{-- 5. TOTAL Y TEXTO --}}
        <div class="mb-8">
            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Total del Monto</label>
            <div class="text-2xl font-bold text-gray-800">
                $ {{ number_format($solicitud->monto_total, 2, ',', '.') }}
            </div>
            
            <div class="mt-4 text-sm text-gray-500 uppercase font-semibold tracking-wide" id="monto-en-letras">
                Calculando...
            </div>
            <div class="h-px bg-gray-200 mt-2 w-full"></div>
        </div>

        {{-- 6. OBJETO Y OBSERVACIONES --}}
        <div class="space-y-6 mb-8">
            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Objeto de Comisión</label>
                <p class="text-gray-700 leading-relaxed">
                    {{ $solicitud->objeto_comision }}
                </p>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Observaciones</label>
                <p class="text-gray-700 leading-relaxed">
                    {{ $solicitud->observacion ?? 'Sin observaciones adicionales.' }}
                </p>
                <div class="h-px bg-gray-200 mt-2 w-full"></div>
            </div>
        </div>

        {{-- 7. BOTONERA  --}}
        <div class="flex flex-col md:flex-row justify-end items-center gap-4 mt-10">
            {{-- Botón Volver (Gris) --}}
            <a href="#" class="px-6 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-md hover:bg-gray-300 transition duration-200 flex items-center">
                Volver al Panel
            </a>

            {{-- Botón Imprimir  --}}
            <a href="{{ route('generar.pdf', $solicitud->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                IMPRIMIR DOCUMENTO
            </a>
        </div>

    </div>

    {{-- SCRIPT JS --}}
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
            if (num === 0) return 'CERO PESOS';
            
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
            return texto.trim() + ' PESOS'; 
        }
    </script>
</div>