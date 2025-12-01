<div class="flex flex-col rounded-xl bg-white shadow-lg border border-gray-100 font-sans">
    
    {{-- CONTENEDOR DE LA TABLA --}}
    <div class="overflow-x-auto rounded-t-xl">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    {{-- ENCABEZADO --}}
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-20">Nº</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Destino</th>
                            
                            {{-- NUEVA COLUMNA: MONTO --}}
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Monto</th>
                            
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                            
                            {{-- Ajustamos el ancho de la columna acciones para que no se estire infinitamente --}}
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-48">Acciones</th>
                        </tr>
                    </thead>
                    
                    {{-- CUERPO --}}
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($solicitudes as $solicitud)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                {{-- ID --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    #{{ $solicitud->id }}
                                </td>

                                {{-- DESTINO --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                    @if($solicitud->provincia) 
                                        {{ Str::limit($solicitud->provincia, 25) }} 
                                    @else 
                                        {{ $solicitud->localidad->nombre_localidades ?? ($solicitud->distrito->distrito ?? '-') }} 
                                    @endif
                                </td>

                                {{-- MONTO --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                    $ {{ number_format($solicitud->monto_total, 2, ',', '.') }}
                                </td>

                                {{-- FECHA --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $solicitud->created_at->format('d/m/Y') }}
                                </td>

                                {{-- ESTADO --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($solicitud->nombre_estado === 'Pendiente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                            <span class="w-1.5 h-1.5 mr-1.5 bg-orange-500 rounded-full"></span> Pendiente
                                        </span>
                                    @elseif($solicitud->nombre_estado === 'Aprobada')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span> Aprobada
                                        </span>
                                    @elseif($solicitud->nombre_estado === 'Cancelada')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span> Cancelada
                                        </span>
                                    @endif
                                </td>

                                {{-- ACCIONES (Ahora más compactas y pegadas al contenido) --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        
                                        {{-- Botón Continuar --}}
                                        @if($solicitud->nombre_estado === 'Pendiente')
                                            <button 
                                                wire:click="confirmarAprobacion({{ $solicitud->id }})" 
                                                class="text-white bg-[#1e3a8a] hover:bg-blue-900 font-bold rounded-md text-xs px-3 py-1.5 shadow-sm transition flex items-center gap-1"
                                            >
                                                Continuar
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </button>
                                        @endif

                                        {{-- Menú de Puntos (Dropdown) --}}
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition focus:outline-none">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                            </button>

                                            <div 
                                                x-show="open" 
                                                @click.away="open = false"
                                                class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-xl border border-gray-100 z-50 py-1 origin-top-right ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                style="display: none;"
                                            >
                                                <a href="{{ route('solicitud.ver', $solicitud->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1e3a8a] w-full text-left">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    Ver Detalle
                                                </a>

                                                @if($solicitud->nombre_estado === 'Pendiente')
                                                    <button wire:click="confirmarCancelacion({{ $solicitud->id }})" @click="open = false" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Cancelar
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <p class="text-sm">No hay solicitudes registradas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- FOOTER CON PAGINACIÓN --}}
    <div class="border-t border-gray-200 bg-white p-4 rounded-b-xl flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <div class="text-sm text-gray-500">
            Mostrando 
            <span class="font-bold text-gray-700">{{ $solicitudes->firstItem() ?? 0 }}</span> 
            a 
            <span class="font-bold text-gray-700">{{ $solicitudes->lastItem() ?? 0 }}</span> 
            de 
            <span class="font-bold text-gray-700">{{ $solicitudes->total() }}</span> 
            resultados
        </div>

        <div class="flex items-center gap-1">
            {{-- Anterior --}}
            <button wire:click="previousPage" @if($solicitudes->onFirstPage()) disabled @endif class="p-2 rounded-full {{ $solicitudes->onFirstPage() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            {{-- Páginas --}}
            @foreach ($solicitudes->getUrlRange(1, $solicitudes->lastPage()) as $page => $url)
                @if ($page == $solicitudes->currentPage())
                    <button class="w-8 h-8 rounded-full bg-[#1e3a8a] text-white text-xs font-bold shadow-md transition">{{ $page }}</button>
                @else
                    @if($page == 1 || $page == $solicitudes->lastPage() || abs($page - $solicitudes->currentPage()) <= 1)
                        <button wire:click="gotoPage({{ $page }})" class="w-8 h-8 rounded-full text-gray-600 hover:bg-gray-100 text-xs font-medium transition">{{ $page }}</button>
                    @elseif(abs($page - $solicitudes->currentPage()) == 2)
                        <span class="text-gray-400 text-xs px-1">...</span>
                    @endif
                @endif
            @endforeach

            {{-- Siguiente --}}
            <button wire:click="nextPage" @if(!$solicitudes->hasMorePages()) disabled @endif class="p-2 rounded-full {{ !$solicitudes->hasMorePages() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>

    {{-- MODAL 1: CONTINUAR PROCESO (APROBAR) --}}
    @if($mostrarModalAprobar)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="cerrarModales"></div>
            <div class="relative bg-white rounded-xl p-6 w-full max-w-sm shadow-2xl border-t-4 border-[#142448]">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-blue-50 mb-4">
                        <svg class="h-8 w-8 text-[#142448]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">¿Continuar Proceso?</h3>
                    <div class="mt-2 text-sm text-gray-600 space-y-2">
                        <p>Se iniciará la etapa de <strong>Certificación y Liquidación</strong>.</p>
                    </div>
                    <div class="mt-6 flex justify-center gap-3">
                        <button wire:click="cerrarModales" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Cancelar</button>
                        <button wire:click="aprobarSolicitud" class="px-4 py-2 bg-[#142448] text-white rounded-lg text-sm font-bold hover:bg-[#0f1b36] shadow-md transition flex items-center gap-2">
                            <span>Ir a Certificar</span> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
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