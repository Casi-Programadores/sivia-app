<div class="p-6 bg-gray-50 min-h-screen font-sans text-slate-600">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-[#162953]">Gestión de Solicitudes</h1>
            <p class="text-sm text-gray-500 mt-1">Historial completo y administración de viáticos.</p>
        </div>
        <div>
            <a href="{{ route('solicitudes.crear') }}" class="bg-[#162953] hover:bg-[#0f1b36] text-white px-5 py-2.5 rounded-lg shadow-md transition flex items-center gap-2 font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva Solicitud
            </a>
        </div>
    </div>

    {{-- PANEL DE FILTROS ORGANIZADO --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
        
        <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
            <h3 class="text-sm font-bold text-gray-700 uppercase flex items-center gap-2">
                <svg class="w-5 h-5 text-[#162953]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filtros Avanzados
            </h3>
            
            {{-- Botón Limpiar --}}
            <button wire:click="limpiarFiltros" class="text-xs font-bold text-gray-400 hover:text-red-500 flex items-center gap-1 transition uppercase tracking-wide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Limpiar Todo
            </button>
        </div>
        
        {{-- Grid de Filtros --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- 1. Búsqueda General --}}


            {{-- 2. Empleado (Nombre Completo) --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Empleado</label>
                <select wire:model.live="search_empleado" class="w-full rounded-lg border-gray-300 text-sm focus:ring-[#162953] focus:border-[#162953]">
                    <option value="">Todos los Empleados</option>
                    @foreach($empleados as $emp)
                        {{-- CAMBIO AQUÍ: Mostrar Apellido y Nombre --}}
                        <option value="{{ $emp->id }}">{{ $emp->persona->apellido }}, {{ $emp->persona->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Estado --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Estado</label>
                <select wire:model.live="filtro_estado" class="w-full rounded-lg border-gray-300 text-sm focus:ring-[#162953] focus:border-[#162953]">
                    <option value="">Todos los Estados</option>
                    @foreach($estados as $est)
                        <option value="{{ $est->id }}">{{ $est->nombre_estado }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 4. Destino --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Destino</label>
                <input type="text" wire:model.live.debounce.500ms="search_destino" placeholder="Localidad..." class="w-full rounded-lg border-gray-300 text-sm focus:ring-[#162953] focus:border-[#162953]">
            </div>

            {{-- 5. Rango de Fechas --}}
            <div class="md:col-span-2 grid grid-cols-2 gap-4 pt-2 lg:pt-0 border-t border-gray-100 lg:border-none mt-2 lg:mt-0">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Desde Fecha</label>
                    <input type="date" wire:model.live="fecha_desde" class="w-full rounded-lg border-gray-300 text-sm focus:ring-[#162953] focus:border-[#162953]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Hasta Fecha</label>
                    <input type="date" wire:model.live="fecha_hasta" class="w-full rounded-lg border-gray-300 text-sm focus:ring-[#162953] focus:border-[#162953]">
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA DE RESULTADOS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-bold w-20">Nº</th>
                        <th class="px-6 py-4 font-bold w-32">Fecha</th>
                        <th class="px-6 py-4 font-bold">Destino</th>
                                                
                        <th class="px-6 py-4 font-bold">Personal Asignado</th>
                        <th class="px-6 py-4 font-bold">Monto Total</th>
                        <th class="px-6 py-4 font-bold text-center">Estado</th>
                        <th class="px-6 py-4 font-bold text-right w-40">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($solicitudes as $sol)
                        <tr class="hover:bg-blue-50/30 transition">
                            
                            {{-- ID --}}
                            <td class="px-6 py-4 font-bold text-[#162953]">
                                #{{ $sol->id }}
                            </td>

                            {{-- Fecha --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $sol->created_at->format('d/m/Y') }}
                            </td>

                            {{-- Destino --}}
                            <td class="px-6 py-4 font-medium text-gray-800">
                                @if($sol->provincia)
                                    <span class="text-gray-800">{{ $sol->provincia }}</span>
                                @else
                                    {{ $sol->localidad->nombre_localidades ?? '-' }} <span class="text-gray-400">/</span> {{ $sol->distrito->distrito ?? '-' }}
                                @endif
                            </td>

                            {{-- Personal --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    @foreach($sol->empleados as $emp)
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-[9px] font-bold text-gray-600 shrink-0">
                                                {{ substr($emp->persona->nombre, 0, 1) }}{{ substr($emp->persona->apellido, 0, 1) }}
                                            </div>
                                            <span class="truncate max-w-[180px]">{{ $emp->persona->apellido }}, {{ $emp->persona->nombre }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            {{-- Monto --}}
                            <td class="px-4 py-4 font-medium font-bold text-gray-700">
                                $ {{ number_format($sol->monto_total, 2, ',', '.') }}
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4 text-center">
                                @if($sol->estado_nombre === 'Pendiente')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                        Pendiente
                                    </span>
                                @elseif($sol->estado_nombre === 'Aprobada')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        Aprobada
                                    </span>
                                @elseif($sol->estado_nombre === 'Cancelada')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        Cancelada
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    
                                    {{-- Botón Ver --}}
                                    <a href="{{ route('solicitud.ver', $sol->id) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition" title="Ver Detalle">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    {{-- Botón Continuar (Solo Pendientes) --}}
                                    @if($sol->estado_nombre === 'Pendiente')
                                        <a href="{{ route('solicitudes.certificar', $sol->id) }}" class="flex items-center gap-1 px-3 py-1.5 bg-[#162953] text-white text-xs font-bold rounded hover:bg-[#0f1b36] transition shadow-sm" title="Continuar Proceso">
                                            <span>Continuar</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <p>No se encontraron solicitudes con los filtros actuales.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $solicitudes->links() }}
        </div>
    </div>

</div>