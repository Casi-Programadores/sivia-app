<div class="space-y-6 font-sans text-slate-600">

    {{-- 1. HEADER Y BOTÓN EXPORTAR --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#162953]">Reporte Mensual de Liquidaciones</h1>
            <p class="text-sm text-gray-500 mt-1">Genere reportes y consulte el historial de liquidaciones de viáticos aprobadas.</p>
        </div>
        <div>
            <button wire:click="exportar" class="bg-[#162953] hover:bg-[#0f1b36] text-white px-5 py-2.5 rounded-lg font-semibold shadow-md transition flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Exportar Reporte
            </button>
        </div>
    </div>

    {{-- 2. FILTROS DE BÚSQUEDA --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-2 mb-4 text-[#162953]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            <h3 class="font-bold text-lg">Filtros de Búsqueda</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            {{-- Filtro Mes --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Mes</label>
                <input type="month" wire:model.live="mes" class="w-full rounded-lg border-gray-300 focus:border-[#162953] focus:ring-[#162953] text-sm py-2">
            </div>

            {{-- Filtro Empleado --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Empleado</label>
                <select wire:model.live="empleado_id" class="w-full rounded-lg border-gray-300 focus:border-[#162953] focus:ring-[#162953] text-sm py-2">
                    <option value="">Todos los empleados</option>
                    @foreach($todosEmpleados as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->persona->apellido }}, {{ $emp->persona->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro Destino --}}
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Destino</label>
                <input type="text" wire:model.live.debounce.500ms="destino" placeholder="Distrito o Provincia" class="w-full rounded-lg border-gray-300 focus:border-[#162953] focus:ring-[#162953] text-sm py-2">
            </div>

            {{-- Botones Acción --}}
            <div class="flex gap-2">
                <button wire:click="$refresh" class="flex-1 bg-[#162953] text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-[#0f1b36] transition shadow-sm">
                    Filtrar
                </button>
                <button wire:click="limpiarFiltros" class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-300 transition">
                    Limpiar
                </button>
            </div>
        </div>
    </div>

    {{-- 3. TARJETAS DE ESTADÍSTICAS (KPIs) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Card 1: Total Liquidaciones --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden group">
            <div class="absolute left-0 top-0 h-full w-1 bg-blue-500"></div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Total Liquidaciones</p>
                <h4 class="text-3xl font-bold text-[#162953]">{{ $totalLiquidaciones }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        {{-- Card 2: Total Monto --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden group">
            <div class="absolute left-0 top-0 h-full w-1 bg-emerald-500"></div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Monto Total Liquidado</p>
                <h4 class="text-3xl font-bold text-emerald-600">$ {{ number_format($totalMonto, 0, ',', '.') }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        {{-- Card 3: Empleados --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden group">
            <div class="absolute left-0 top-0 h-full w-1 bg-orange-500"></div>
            <div>
                <p class="text-sm text-gray-500 font-medium mb-1">Agentes Involucrados</p>
                <h4 class="text-3xl font-bold text-orange-600">{{ $totalEmpleados }}</h4>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- 4. TABLA DE RESULTADOS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-800">Listado de Liquidaciones</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Fecha Solicitud</th>
                        <th class="px-6 py-3 font-semibold">Empleado</th>
                        <th class="px-6 py-3 font-semibold">Legajo</th>
                        <th class="px-6 py-3 font-semibold">Destino</th>
                        <th class="px-6 py-3 font-semibold text-center">Días</th>
                        <th class="px-6 py-3 font-semibold">Monto Individual</th>
                        <th class="px-6 py-3 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($resultados as $solicitud)
                        
                        {{-- CALCULOS POR FILA --}}
                        @php
                            $pct = $solicitud->porcentaje->porcentaje ?? 100;
                            // Fórmula: (Base * Dias * (Pct/100))
                            $montoIndividual = ($solicitud->monto * $solicitud->cantidad_dias) * ($pct / 100);
                        @endphp

                        @foreach($solicitud->empleados as $empleado)
                            {{-- FILTRO VISUAL: Ocultamos empleados si no coinciden --}}
                            @if($empleado_id && $empleado->id != $empleado_id)
                                @continue
                            @endif

                            {{-- IMPORTANTÍSIMO: wire:key único para evitar errores visuales al limpiar --}}
                            <tr wire:key="row-{{ $solicitud->id }}-{{ $empleado->id }}" class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $solicitud->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800">
                                    {{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $empleado->numero_legajo }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 uppercase text-xs">
                                    {{ $solicitud->provincia ?? ($solicitud->distrito->distrito ?? '-') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $solicitud->cantidad_dias }}
                                </td>
                                <td class="px-6 py-4 font-bold text-[#162953]">
                                    $ {{ number_format($montoIndividual, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('solicitud.ver', $solicitud->id) }}" class="inline-flex items-center gap-1 text-[#162953] font-bold text-xs hover:underline bg-blue-50 px-3 py-1.5 rounded-md border border-blue-100 transition hover:bg-blue-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p>No se encontraron liquidaciones para este período.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN  --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <div class="text-sm text-gray-500">
                Mostrando 
                <span class="font-bold text-gray-700">{{ $resultados->firstItem() ?? 0 }}</span> 
                a 
                <span class="font-bold text-gray-700">{{ $resultados->lastItem() ?? 0 }}</span> 
                de 
                <span class="font-bold text-gray-700">{{ $resultados->total() }}</span> 
                resultados
            </div>

            <div class="flex items-center gap-1">
                {{-- Anterior --}}
                <button wire:click="previousPage" @if($resultados->onFirstPage()) disabled @endif class="p-2 rounded-full {{ $resultados->onFirstPage() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                {{-- Páginas --}}
                @foreach ($resultados->getUrlRange(1, $resultados->lastPage()) as $page => $url)
                    @if ($page == $resultados->currentPage())
                        <button class="w-8 h-8 rounded-full bg-[#162953] text-white text-xs font-bold shadow-md transition">{{ $page }}</button>
                    @else
                        @if($page == 1 || $page == $resultados->lastPage() || abs($page - $resultados->currentPage()) <= 1)
                            <button wire:click="gotoPage({{ $page }})" class="w-8 h-8 rounded-full text-gray-600 hover:bg-gray-100 text-xs font-medium transition">{{ $page }}</button>
                        @elseif(abs($page - $resultados->currentPage()) == 2)
                            <span class="text-gray-400 text-xs px-1">...</span>
                        @endif
                    @endif
                @endforeach

                {{-- Siguiente --}}
                <button wire:click="nextPage" @if(!$resultados->hasMorePages()) disabled @endif class="p-2 rounded-full {{ !$resultados->hasMorePages() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>