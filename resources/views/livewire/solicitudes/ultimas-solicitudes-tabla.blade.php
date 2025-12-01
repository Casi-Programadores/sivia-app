<div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-gray-700 uppercase bg-[#eef2f6]">
            <tr>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">Nº</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">DESTINO</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">FECHA</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">ESTADO</th>
                <th scope="col" class="px-6 py-4 font-bold text-gray-500">ACCIÓN</th>
            </tr>
        </thead>
        
        <tbody class="divide-y divide-gray-100">
            @forelse ($solicitudes as $solicitud)
                <tr class="bg-white hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $solicitud->id }}</td>
                    <td class="px-6 py-4 text-gray-700 font-medium">
                        @if($solicitud->provincia) {{ $solicitud->provincia }} @else {{ $solicitud->localidad->nombre_localidades ?? ($solicitud->distrito->distrito ?? '-') }} @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $solicitud->created_at->format('Y-m-d') }}</td>

                    {{-- ESTADO --}}
                    <td class="px-6 py-4">
                        @if($solicitud->nombre_estado === 'Pendiente')
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-orange-200">Pendiente</span>
                        @elseif($solicitud->nombre_estado === 'Aprobada')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-green-200">Aprobada</span>
                        @elseif($solicitud->nombre_estado === 'Cancelada')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-red-200">Cancelada</span>
                        @endif
                    </td>

                    {{-- ACCIONES --}}
                    <td class="px-6 py-4">
                        @if($solicitud->nombre_estado === 'Pendiente')
                            <div class="flex items-center gap-2">
                                {{-- Botón CONTINUAR (Abre modal aprobar) --}}
                                <button 
                                    wire:click="confirmarAprobacion({{ $solicitud->id }})" 
                                    class="bg-[#1e3a8a] hover:bg-blue-900 text-white px-4 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition"
                                >
                                    Continuar
                                </button>

                                {{-- Botón CANCELAR (Abre modal cancelar) --}}
                                <button 
                                    wire:click="confirmarCancelacion({{ $solicitud->id }})"
                                    class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition border border-red-200"
                                >
                                    Cancelar
                                </button>
                            </div>
                        @else
                            <span class="text-gray-400 text-xs italic font-medium">Acción finalizada</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay solicitudes recientes.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- MODAL 1: APROBAR (CONTINUAR) --}}
    @if($mostrarModalAprobar)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="cerrarModales"></div>
            
            <div class="relative bg-white rounded-xl p-6 w-full max-w-sm shadow-2xl border-t-4 border-[#142448]">
                <div class="text-center">
                    
                    {{-- Ícono de Información/Avance (Azul) --}}
                    <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-blue-50 mb-4">
                        <svg class="h-8 w-8 text-[#142448]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900">¿Continuar Proceso?</h3>
                    
                    <div class="mt-2 text-sm text-gray-600 space-y-2">
                        <p>
                            Se iniciará la etapa de <strong>Certificación y Liquidación</strong>.
                        </p>
                    </div>

                    <div class="mt-6 flex justify-center gap-3">
                        <button 
                            wire:click="cerrarModales" 
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition"
                        >
                            Cancelar
                        </button>
                        
                        <button 
                            wire:click="aprobarSolicitud" 
                            class="px-4 py-2 bg-[#142448] text-white rounded-lg text-sm font-bold hover:bg-[#0f1b36] shadow-md transition flex items-center gap-2"
                        >
                            <span>Ir a Certificar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL 2: CANCELAR --}}
    @if($mostrarModalCancelar)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="cerrarModales"></div>
            <div class="relative bg-white rounded-xl p-6 w-full max-w-sm shadow-2xl border-t-4 border-red-800">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">¿Cancelar Solicitud?</h3>
                    <p class="text-sm text-gray-500 mt-2">Esta acción rechazará la solicitud y finalizará el proceso. <br><span class="text-red-500 font-semibold">No se podrá deshacer.</span></p>
                    <div class="mt-6 flex justify-center gap-3">
                        <button wire:click="cerrarModales" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Volver</button>
                        <button wire:click="cancelarSolicitud" class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm font-medium hover:bg-red-700 shadow-md">Sí, Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>