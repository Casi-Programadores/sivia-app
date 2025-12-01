<div class="w-full max-w-6xl mx-auto bg-white rounded-lg shadow-lg border border-gray-200 font-sans">
    
    {{-- Encabezado Estilo Institucional --}}
    <div class="bg-blue-50/50 rounded-t-lg p-6 border-b border-blue-100">
        <h2 class="text-2xl font-bold text-blue-900">Nueva Solicitud de Viático</h2>
        <p class="text-gray-500 text-sm mt-1">Complete los detalles de la comisión y asigne el personal correspondiente.</p>
    </div>

    @if (session()->has('message'))
        <div class="mx-6 mt-6 bg-green-50 border-l-4 border-green-600 text-green-800 p-4 rounded-r shadow-sm flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="p-6 md:p-8">
        <form wire:submit.prevent="save" class="grid gap-y-8" novalidate>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                <div class="space-y-6">
                    
                    <div class="w-full">
                        <h6 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            1. Datos de la Comisión
                        </h6>
                        <hr class="mb-4 mt-2 border-gray-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nota Interna</label>
                        <select wire:model.blur="form.numero_nota_interna_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 transition py-2.5">
                            <option value="">Seleccione N° Nota...</option>
                            @foreach($notas_internas as $nota)
                                <option value="{{ $nota->id }}">{{ $nota->numero }}</option>
                            @endforeach
                        </select>
                        @error('form.numero_nota_interna_id') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Objeto de la Comisión</label>
                        <input type="text" wire:model.blur="form.objeto_comision" placeholder="Ej: Auditoría contable en sucursal" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5">
                        @error('form.objeto_comision') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha Fin</label>
                            <input type="datetime-local" wire:model.blur="form.fecha_fin" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5">
                            @error('form.fecha_fin') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cantidad Días</label>
                            <input type="number" wire:model.live="form.cantidad_dias" min="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5">
                            @error('form.cantidad_dias') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                     <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Monto Diario Base</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">$</span>
                                <input type="number" step="1" wire:model.live="form.monto" class="pl-7 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5">
                            </div>
                            @error('form.monto') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Total Estimado</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">$</span>
                                <input type="text" value="{{ number_format($form->monto_total, 2) }}" readonly class="pl-7 w-full bg-gray-200 text-gray-700 font-bold rounded-lg border-gray-300 cursor-not-allowed py-2.5">
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1 text-right italic">(Base x Días x Personas)</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Porcentaje Aplicable</label>
                        <select wire:model.blur="form.porcentaje_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5">
                            <option value="">Seleccione %...</option>
                            @foreach($porcentajes as $pct)
                                <option value="{{ $pct->id }}">{{ $pct->porcentaje }}%</option>
                            @endforeach
                        </select>
                        @error('form.porcentaje_id') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div class="space-y-6">
                    
                    <div class="w-full">
                        <h6 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            2. Ubicación y Personal
                        </h6>
                        <hr class="mb-4 mt-2 border-gray-200" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Distrito</label>
                            <select wire:model.blur="form.distrito_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5">
                                <option value="">Seleccione...</option>
                                @foreach($distritos as $dist)
                                    <option value="{{ $dist->id }}">{{ $dist->distrito }}</option>
                                @endforeach
                            </select>
                            @error('form.distrito_id') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Localidad</label>
                            <select wire:model.blur="form.localidad_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5">
                                <option value="">Seleccione...</option>
                                @foreach($localidades as $loc)
                                    <option value="{{ $loc->id }}">{{ $loc->nombre_localidades }}</option>
                                @endforeach
                            </select>
                            @error('form.localidad_id') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-2">
                         <div class="flex items-center justify-between mb-4">
                            <label for="es_fuera_provincia" class="text-base font-semibold text-gray-800 cursor-pointer select-none">
                                ¿Comisión fuera de la provincia?
                            </label>
                            
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="form.es_fuera_provincia" id="es_fuera_provincia" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-900"></div>
                            </label>
                        </div>

                        <div class="overflow-hidden transition-all duration-300 ease-in-out {{ $form->es_fuera_provincia ? 'max-h-24 opacity-100' : 'max-h-0 opacity-0' }}">
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-2">Especifique Provincia / Destino</label>
                                <input type="text" wire:model.blur="form.nombre_provincia" placeholder="Ej: Córdoba, Buenos Aires..." class="w-full rounded-lg border-blue-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5 bg-blue-50/30">
                                @error('form.nombre_provincia') <span class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-4" />

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Asignar Empleados</label>
                        <div class="flex gap-2 mb-3">
                            <select wire:model="empleado_seleccionado_id" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 text-sm py-2.5">
                                <option value="">Buscar empleado...</option>
                                @foreach($todos_empleados as $emp)
                                    <option value="{{ $emp->id }}">
                                        {{ $emp->numero_legajo }} - {{ $emp->persona->apellido }}, {{ $emp->persona->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" wire:click="agregarEmpleado" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Agregar
                            </button>
                        </div>
                        @error('empleado_seleccionado_id') <span class="text-red-500 text-xs block mb-2 font-semibold">{{ $message }}</span> @enderror
                        @error('form.empleados_agregados') <span class="text-red-500 text-xs block mb-2 font-semibold">Debe agregar al menos un empleado.</span> @enderror

                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                            <div class="max-h-56 overflow-y-auto">
                                @if(count($empleadosListados) > 0)
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50 sticky top-0">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Legajo</th>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre</th>
                                                <th class="px-4 py-3 text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($empleadosListados as $index => $empleado)
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 font-medium">{{ $empleado->numero_legajo }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                        <button type="button" wire:click="quitarEmpleado({{ $index }})" class="text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded transition" title="Quitar">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="p-8 text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <p class="text-sm text-gray-400 italic">No hay empleados asignados.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones Generales</label>
                        <textarea wire:model.blur="form.observacion" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 py-2.5 resize-none" placeholder="Ingrese detalles adicionales aquí..."></textarea>
                    </div>

                </div>
            </div>

            <div class="mt-4 pt-6 border-t border-gray-100 flex justify-end">
                <button 
                    type="button" 
                    wire:click="confirmarGuardado"
                    wire:loading.attr="disabled"
                    class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 px-10 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-150 flex items-center text-base"
                >
                    <span wire:loading.remove wire:target="save">
                        Generar Solicitud
                    </span>

                    <span wire:loading wire:target="confirmarGuardado" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- MODAL DE CONFIRMACIÓN (ADVERTENCIA) --}}
    @if ($showConfirmationModal)
    <div class="fixed inset-0 flex items-center justify-center z-[60]">
        <!-- Fondo oscuro -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Contenido del Modal -->
        <div class="relative bg-white rounded-xl p-8 w-full max-w-md shadow-2xl transform transition-all scale-100 border-t-4 border-yellow-500">
            <div class="text-center">
                {{-- Ícono de Alerta --}}
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                    <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">¿Está seguro?</h2>
                
                <p class="text-gray-600 mb-6 text-sm">
                    Está a punto de generar una solicitud oficial. <br>
                    <span class="font-semibold text-red-600">Una vez guardada, no podrá realizar modificaciones.</span>
                    <br>Por favor, verifique que todos los datos sean correctos.
                </p>

                <div class="flex gap-3 justify-center">
                    {{-- Botón Cancelar (Cierra el modal) --}}
                    <button 
                        wire:click="$set('showConfirmationModal', false)"
                        class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition border border-gray-300"
                    >
                        Revisar datos
                    </button>

                    {{-- Botón Confirmar (Ejecuta el guardado real) --}}
                    <button 
                        wire:click="save"
                        wire:loading.attr="disabled"
                        class="px-5 py-2.5 bg-blue-900 text-white font-semibold rounded-lg hover:bg-blue-800 transition shadow-md flex items-center"
                    >
                        <span wire:loading.remove wire:target="save">Confirmar y Guardar</span>
                        <span wire:loading wire:target="save" class="ml-2">Guardando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL DE ÉXITO --}}
    @if ($showSuccessModal)
    <div class="fixed inset-0 flex items-center justify-center z-[60]">
        <!-- Fondo oscuro -->
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <!-- Contenido del Modal -->
        <div class="relative bg-white rounded-xl p-8 w-full max-w-md shadow-2xl transform transition-all scale-100 border-t-4 border-green-600">
            <div class="text-center">
                {{-- Ícono de éxito --}}
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">¡Solicitud generada!</h2>
                <p class="text-gray-600 mb-6 text-sm">
                    La solicitud de viático fue creada correctamente.
                    <br>
                    <span class="font-semibold text-blue-900">
                        Ahora puede visualizar los detalles completos.
                    </span>
                </p>
                <div class="flex justify-center">
                    <button 
                        wire:click="irAVisualizarSolicitud"
                        class="px-6 py-2.5 bg-blue-900 text-white font-semibold rounded-lg hover:bg-blue-800 transition shadow-md flex items-center"
                    >
                        Ver Solicitud
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>