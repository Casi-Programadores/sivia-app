<div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
    <table class="w-full text-sm text-left text-gray-600">
        {{-- ENCABEZADO --}}
        <thead class="text-xs text-gray-700 uppercase bg-[#eef2f6]">
            <tr>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">ID</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">DESTINO</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">FECHA</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">ESTADO</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">ACCIÓN</th>
            </tr>
        </thead>
        
        {{-- CUERPO --}}
        <tbody class="divide-y divide-gray-100">
            @forelse ($solicitudes as $solicitud)
                {{-- Lógica simulada de estado (ajústalo a tu modelo real) --}}
                @php
                    // Esto deberías traerlo de tu relación real, ej: $solicitud->ultimoDetalle->estado->nombre_estado
                    // Para el ejemplo visual uso lógica aleatoria o fija
                    $estado = 'Pendiente'; 
                    if($loop->index == 1) $estado = 'Aprobada';
                    if($loop->index == 2) $estado = 'Rechazada';
                    if($loop->index == 3) $estado = 'Aprobada';
                @endphp

                <tr class="bg-white hover:bg-gray-50 transition-colors">
                    {{-- ID --}}
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $solicitud->id }}
                    </td>

                    {{-- DESTINO --}}
                    <td class="px-6 py-4 text-gray-700 font-medium">
                        @if($solicitud->provincia)
                            {{ $solicitud->provincia }}
                        @else
                            {{ $solicitud->localidad->nombre_localidades ?? ($solicitud->distrito->distrito ?? '-') }}
                        @endif
                    </td>

                    {{-- FECHA --}}
                    <td class="px-6 py-4 text-gray-500">
                        {{ $solicitud->created_at->format('Y-m-d') }}
                    </td>

                    {{-- ESTADO (Badges de colores) --}}
                    <td class="px-6 py-4">
                        @if($estado === 'Pendiente')
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-orange-200">
                                Pendiente
                            </span>
                        @elseif($estado === 'Aprobada')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-green-200">
                                Aprobada
                            </span>
                        @elseif($estado === 'Rechazada')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-red-200">
                                Rechazada
                            </span>
                        @endif
                    </td>

                    {{-- ACCIONES --}}
                    <td class="px-6 py-4">
                        @if($estado === 'Pendiente')
                            <div class="flex items-center gap-2">
                                {{-- Botón Continuar (Azul Oscuro) --}}
                                <a href="{{ route('solicitud.ver', $solicitud->id) }}" class="bg-[#1e3a8a] hover:bg-blue-900 text-white px-4 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition">
                                    Continuar
                                </a>
                                {{-- Botón Cancelar (Rojo Suave) --}}
                                <button class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition border border-red-200">
                                    Cancelar
                                </button>
                            </div>
                        @else
                            <span class="text-gray-400 text-xs italic font-medium">
                                Acción finalizada
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                        No hay solicitudes recientes.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>