<div>
    {{-- CONTENEDOR PRINCIPAL --}}
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg border border-gray-200 font-sans overflow-hidden">

        {{-- 1. ENCABEZADO INSTITUCIONAL --}}
        <div class="bg-blue-50/50 p-6 md:p-8 border-b border-blue-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-blue-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Detalle de Solicitud
                </h2>
                <p class="text-gray-500 text-sm mt-1">Información completa del viático registrado.</p>
            </div>
            <div class="bg-white border border-blue-200 rounded-lg px-4 py-2 shadow-sm">
                <span class="text-xs text-gray-500 uppercase font-bold tracking-wider">Solicitud</span>
                <div class="text-2xl font-black text-blue-900 leading-none text-center">
                    #{{ str_pad($solicitud->id ?? '0', 0, '0', STR_PAD_LEFT) }}
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">

            {{-- 2. TARJETA DE RESUMEN (DATOS CLAVE) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Nota Interna</label>
                    <div class="text-gray-800 text-lg font-semibold mt-1">
                        {{ $solicitud->numeroNotaInterna->numero ?? 'S/N' }}
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 md:col-span-2 flex items-center justify-between">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Salida</label>
                        <div class="text-gray-800 text-lg font-semibold mt-1">
                            {{ $solicitud->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                    <div class="text-right">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Regreso / Fin</label>
                        <div class="text-gray-800 text-lg font-semibold mt-1">
                             {{-- Asumiendo que fecha_fin es un objeto Carbon, si es string usa parse --}}
                             {{ \Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Duración</label>
                    <div class="text-gray-800 text-lg font-semibold mt-1">
                        {{ $solicitud->cantidad_dias }} <span class="text-sm text-gray-500 font-normal">Días</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- COLUMNA IZQUIERDA (2/3): INFORMACIÓN DETALLADA --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- SECCIÓN DESTINO --}}
                    <div>
                        <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide border-b border-gray-100 pb-2 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ubicación / Destino
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <span class="block text-xs text-gray-400 font-semibold uppercase">Provincia</span>
                                <span class="text-gray-800 font-medium">{{ $solicitud->provincia ?? 'Formosa' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 font-semibold uppercase">Distrito</span>
                                <span class="text-gray-800 font-medium">{{ $solicitud->distrito->distrito ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 font-semibold uppercase">Localidad</span>
                                <span class="text-gray-800 font-medium">{{ $solicitud->localidad->nombre_localidades ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN EMPLEADOS --}}
                    <div>
                        <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide border-b border-gray-100 pb-2 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Personal Asignado
                        </h3>
                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <ul class="divide-y divide-gray-100">
                                @forelse($solicitud->empleados as $empleado)
                                    <li class="px-4 py-3 flex items-center gap-3 hover:bg-gray-50 transition">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                                            {{ substr($empleado->persona->nombre, 0, 1) }}{{ substr($empleado->persona->apellido, 0, 1) }}
                                        </div>
                                        <span class="text-gray-700 font-medium text-sm">
                                            {{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="px-4 py-3 text-gray-400 italic text-sm">Sin empleados asignados</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    {{-- SECCIÓN OBJETO Y OBSERVACIONES --}}
                    <div>
                        <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide border-b border-gray-100 pb-2 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Detalles Adicionales
                        </h3>
                        <div class="bg-blue-50/30 rounded-lg p-5 border border-blue-100 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-blue-900 uppercase mb-1">Objeto de la Comisión</label>
                                <p class="text-gray-700 text-sm leading-relaxed">
                                    {{ $solicitud->objeto_comision }}
                                </p>
                            </div>
                            @if($solicitud->observacion)
                                <div class="border-t border-blue-100 pt-3">
                                    <label class="block text-xs font-bold text-blue-900 uppercase mb-1">Observaciones</label>
                                    <p class="text-gray-600 text-sm leading-relaxed italic">
                                        "{{ $solicitud->observacion }}"
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- COLUMNA DERECHA (1/3): TOTALES Y ACCIONES --}}
                <div class="space-y-6">
                    
                    {{-- TARJETA DE TOTALES --}}
                    <div class="bg-[#142448] rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-4">Resumen Financiero</h3>
                            
                            <div class="mb-4">
                                <span class="block text-xs text-blue-200 opacity-80 mb-1">Monto Individual</span>
                                @php
                                    $cantidad = $solicitud->empleados->count();
                                    $montoInd = $cantidad > 0 ? ($solicitud->monto_total / $cantidad) : 0;
                                @endphp
                                <span class="text-xl font-medium">$ {{ number_format($montoInd, 2, ',', '.') }}</span>
                            </div>

                            <div class="mb-2">
                                <span class="block text-xs text-blue-200 opacity-80 mb-1">Porcentaje Aplicado</span>
                                <span class="text-lg font-medium">{{ $solicitud->porcentaje->porcentaje ?? '100' }}%</span>
                            </div>

                            <div class="border-t border-blue-800 my-4"></div>

                            <div>
                                <span class="block text-sm text-blue-100 font-bold mb-1">TOTAL GENERAL</span>
                                <span class="text-3xl font-bold tracking-tight">$ {{ number_format($solicitud->monto_total, 2, ',', '.') }}</span>
                            </div>
                            
                            <div class="mt-4 p-3 bg-blue-900 rounded-lg border border-blue-700">
                                <p class="text-[10px] text-blue-100 uppercase font-medium leading-tight tracking-wide">
                                    {{ $montoEnLetras }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- BOTONERA --}}
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('generar.pdf', $solicitud->id) }}" target="_blank" class="w-full flex justify-center items-center px-4 py-3 bg-white border-2 border-blue-900 text-blue-900 font-bold rounded-lg hover:bg-blue-50 transition shadow-sm group">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            IMPRIMIR PDF
                        </a>

                        <a href="{{ route('dashboard')}}" class="w-full flex justify-center items-center px-4 py-3 bg-gray-100 text-gray-600 font-semibold rounded-lg hover:bg-gray-200 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Volver
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>