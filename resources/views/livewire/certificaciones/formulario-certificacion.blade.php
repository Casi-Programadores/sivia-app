<div class="max-w-5xl mx-auto py-10 px-4 font-sans text-slate-800">
    
    {{-- Título Principal --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-[#142448] flex items-center gap-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Certificación y Liquidacion de Solicitud
        </h2>
        <p class="text-slate-500 text-sm mt-1 ml-10">Complete los datos administrativos para oficializar la solicitud <strong>#{{ $solicitud->id }}</strong>.</p>
    </div>

    <div class="bg-white w-full rounded-xl shadow-lg border border-gray-200 overflow-hidden relative">
        
        {{-- Mensaje de Estado (Aparece solo al finalizar) --}}
        @if($certificacionRealizada)
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 animate-in slide-in-from-top-2 duration-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <div>
                            <p class="font-bold">¡Certificación y Liquidación Registrada Exitosamente!</p>
                            <p class="text-sm">Puede descargar los documentos individuales en la lista de abajo.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Barra Superior de la Tarjeta --}}
        <div class="bg-gray-50/50 border-b border-gray-100 p-6 flex justify-between items-center">
            <h5 class="text-xl font-bold text-[#142448]">Datos Administrativos</h5>
            <div class="bg-blue-50 text-[#142448] px-3 py-1 rounded-md border border-blue-100 text-xs font-bold uppercase tracking-wider">
                Nota N° {{ $solicitud->numeroNotaInterna->numero ?? 'S/N' }}
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form wire:submit.prevent="confirmarOperacion" class="grid gap-y-8" novalidate>
                
                {{-- SECCIÓN 1: FORMULARIO DE CARGA --}}
                {{-- Si ya se certificó, deshabilitamos visualmente esta sección --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 transition-opacity duration-500 {{ $certificacionRealizada ? 'opacity-40 pointer-events-none grayscale' : '' }}">
                    
                    {{-- Mesa de Entrada --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-8 h-8 rounded-full bg-[#142448] text-white flex items-center justify-center text-sm font-bold">1</span>
                            <h6 class="text-lg font-semibold text-gray-700">Mesa de Entrada</h6>
                        </div>
                        
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="letra">Letra</label>
                                <input id="letra" type="text" wire:model="letra" class="w-full uppercase rounded-lg border-gray-300 focus:border-[#142448] focus:ring-[#142448] shadow-sm uppercase placeholder:normal-case" placeholder=" A" required />
                                @error('letra') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="numero_expediente">Número de Expediente</label>
                                <input id="numero_expediente" type="number" wire:model="numero_expediente" class="w-full rounded-lg border-gray-300 focus:border-[#142448] focus:ring-[#142448] shadow-sm" placeholder="12345" required />
                                @error('numero_expediente') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Resolución --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-8 h-8 rounded-full bg-[#142448] text-white flex items-center justify-center text-sm font-bold">2</span>
                            <h6 class="text-lg font-semibold text-gray-700">Resolución S.G.</h6>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="numero_resolucion">Número de Resolución</label>
                                <input id="numero_resolucion" type="number" wire:model="numero_resolucion" class="w-full rounded-lg border-gray-300 focus:border-[#142448] focus:ring-[#142448] shadow-sm" placeholder="332" required />
                                @error('numero_resolucion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="fecha_resolucion">Fecha de Resolución</label>
                                <input id="fecha_resolucion" type="date" wire:model="fecha_resolucion" class="w-full rounded-lg border-gray-300 focus:border-[#142448] focus:ring-[#142448] shadow-sm" required />
                                @error('fecha_resolucion') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100" />

                {{-- SECCIÓN 2: EMPLEADOS Y DESCARGAS --}}
                <div class="w-full">
                    <div class="flex justify-between items-end mb-4">
                        <h6 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Personal Involucrado
                        </h6>
                        @if($certificacionRealizada)
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded animate-pulse">
                                ● Documentos listos para imprimir
                            </span>
                        @endif
                    </div>
                    
                    {{-- Cambiamos a 1 col en mobile, 2 cols en desktop para que entren los botones --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach($empleados as $empleado)
                            <div class="flex flex-col justify-between p-5 rounded-xl border transition-all duration-500 gap-4
                                {{ $certificacionRealizada 
                                    ? 'border-green-200 bg-green-50/20 shadow-md' 
                                    : 'border-gray-200 bg-white hover:border-[#142448]/30' }}">
                                
                                {{-- Datos del Empleado (Arriba) --}}
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 rounded-full bg-[#142448] text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                                        {{ substr($empleado->persona->nombre, 0, 1) }}{{ substr($empleado->persona->apellido, 0, 1) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-base font-bold text-gray-800 truncate">{{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs font-semibold bg-gray-100 px-2 py-0.5 rounded text-gray-600 border border-gray-200">
                                                LEG: {{ $empleado->numero_legajo }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- BOTONES DE IMPRESIÓN GRANDES (Abajo) --}}
                                @if($certificacionRealizada)
                                    <div class="flex flex-col sm:flex-row gap-2 mt-2 pt-4 border-t border-green-200/50 animate-in fade-in slide-in-from-bottom-2 duration-700">
                                        
                                        {{-- Botón Imprimir Certificación --}}
                                        <a href="{{ route('certificado.pdf', ['solicitud_id' => $solicitud->id, 'empleado_id' => $empleado->id]) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-white border-2 border-[#142448] text-[#142448] text-xs font-bold uppercase tracking-wide rounded-lg hover:bg-[#142448] hover:text-white transition group shadow-sm">
                                            <svg class="w-4 h-4 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Imprimir Certificación
                                        </a>

                                        {{-- Botón Imprimir Liquidación --}}
                                        <a href="{{ route('liquidacion.pdf', ['solicitud_id' => $solicitud->id, 'empleado_id' => $empleado->id]) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-[#142448] border-2 border-[#142448] text-white text-xs font-bold uppercase tracking-wide rounded-lg hover:bg-[#0f1b36] hover:border-[#0f1b36] transition shadow-md">
                                            <svg class="w-4 h-4 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Imprimir Liquidación
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                {{-- BOTONERA PRINCIPAL --}}
                <div class="flex justify-end items-center gap-4 mt-6 pt-6 border-t border-gray-100">
                    
                    @if(!$certificacionRealizada)
                        {{-- ESTADO: CARGA --}}
                        <a href="{{ route('dashboard')}}" class="px-5 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition text-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-[#142448] hover:bg-[#0f1b36] text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5 flex items-center gap-2">
                            <span>Aceptar</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    @else
                        {{-- ESTADO: FINALIZADO --}}
                        <button type="button" wire:click="finalizar" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Finalizar y Salir</span>
                        </button>
                    @endif

                </div>
            </form>
        </div>
    </div>

    {{-- MODAL DE CONFIRMACIÓN (AMARILLO) --}}
    @if ($showConfirmationModal)
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="relative bg-white rounded-xl p-8 w-full max-w-sm shadow-2xl transform transition-all scale-100 border-t-4 border-yellow-500">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">¿Confirmar datos?</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Se vinculará la Resolución y Expediente ingresados. <br>
                    <strong>Esta acción aprobará oficialmente el trámite.</strong>
                </p>
                <div class="flex gap-3 justify-center">
                    <button wire:click="$set('showConfirmationModal', false)" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Revisar</button>
                    <button wire:click="certificar" class="px-4 py-2 bg-[#142448] text-white rounded-lg text-sm font-medium hover:bg-[#0f1b36] shadow-md transition">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div> 