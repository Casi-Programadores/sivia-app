<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-lg border border-gray-100">
    
    <div class="mb-8 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Nueva Solicitud de Viático</h2>
        <p class="text-gray-500 text-sm">Complete los detalles de la comisión y asigne el personal correspondiente.</p>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- SECCIÓN IZQUIERDA: DATOS GENERALES -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-indigo-600 border-b border-indigo-100 pb-2">Datos de la Comisión</h3>

                <!-- Nota Interna -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nota Interna</label>
                    <select wire:model.blur="form.numero_nota_interna_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                        <option value="">Seleccione N° Nota...</option>
                        @foreach($notas_internas as $nota)
                            <option value="{{ $nota->id }}">{{ $nota->numero }}</option>
                        @endforeach
                    </select>
                    @error('form.numero_nota_interna_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Objeto Comisión -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objeto de la Comisión</label>
                    <input type="text" wire:model.blur="form.objeto_comision" placeholder="Ej: Auditoría contable en sucursal" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('form.objeto_comision') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Fechas y Días -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
                        <input type="datetime-local" wire:model.blur="form.fecha_fin" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('form.fecha_fin') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad Días</label>
                        <input type="number" wire:model.live="form.cantidad_dias" min="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('form.cantidad_dias') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                 <!-- Montos -->
                 <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Diario Base</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                            <input type="number" step="0.01" wire:model.live="form.monto" class="pl-7 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        @error('form.monto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Calculado</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                            <!-- Aquí accedemos a la propiedad del objeto form con $form->monto_total -->
                            <input type="text" value="{{ number_format($form->monto_total, 2) }}" readonly class="pl-7 w-full bg-gray-200 text-gray-600 rounded-lg border-gray-300 cursor-not-allowed font-bold">
                        </div>
                        <p class="text-[10px] text-gray-500 mt-1 text-right">(Base x Días x Personas)</p>
                    </div>
                </div>

                <!-- Porcentaje -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Porcentaje Aplicable</label>
                    <select wire:model.blur="form.porcentaje_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Seleccione %...</option>
                        @foreach($porcentajes as $pct)
                            <option value="{{ $pct->id }}">{{ $pct->porcentaje }}%</option>
                        @endforeach
                    </select>
                    @error('form.porcentaje_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- SECCIÓN DERECHA: UBICACIÓN Y PERSONAL -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-indigo-600 border-b border-indigo-100 pb-2">Ubicación y Personal</h3>

                <!-- Ubicación -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Distrito</label>
                        <select wire:model.blur="form.distrito_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seleccione...</option>
                            @foreach($distritos as $dist)
                                <option value="{{ $dist->id }}">{{ $dist->distrito }}</option>
                            @endforeach
                        </select>
                        @error('form.distrito_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Localidad</label>
                        <select wire:model.blur="form.localidad_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seleccione...</option>
                            @foreach($localidades as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->nombre_localidades }}</option>
                            @endforeach
                        </select>
                        @error('form.localidad_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Switch Fuera de Provincia -->
                <div class="flex flex-col bg-indigo-50 p-3 rounded-lg border border-indigo-100">
                    <div class="flex items-center justify-between mb-2">
                        <label for="es_fuera_provincia" class="text-sm font-medium text-gray-900 cursor-pointer select-none">
                            ¿Comisión fuera de la provincia?
                        </label>
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" wire:model.live="form.es_fuera_provincia" id="es_fuera_provincia" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer checked:right-0 checked:border-indigo-600"/>
                            <label for="es_fuera_provincia" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </div>

                    @if($form->es_fuera_provincia)
                        <div class="mt-2 transition-all duration-300 ease-in-out">
                            <label class="block text-xs font-medium text-indigo-700 mb-1">Especifique Provincia / Destino</label>
                            <input type="text" wire:model.blur="form.nombre_provincia" placeholder="Ej: Córdoba, Buenos Aires..." class="w-full rounded border-indigo-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('form.nombre_provincia') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <!-- SECCIÓN EMPLEADOS (AGREGAR DINÁMICO) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Asignar Empleados</label>
                    <div class="flex gap-2 mb-2">
                        <select wire:model="empleado_seleccionado_id" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Buscar empleado...</option>
                            @foreach($todos_empleados as $emp)
                                <option value="{{ $emp->id }}">
                                    {{ $emp->numero_legajo }} - {{ $emp->persona->apellido }}, {{ $emp->persona->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="agregarEmpleado" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                            Agregar
                        </button>
                    </div>
                    @error('empleado_seleccionado_id') <span class="text-red-500 text-xs block mb-2">{{ $message }}</span> @enderror
                    @error('form.empleados_agregados') <span class="text-red-500 text-xs block mb-2">Debe agregar al menos un empleado.</span> @enderror

                    <!-- Lista de Empleados Agregados -->
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden max-h-48 overflow-y-auto shadow-inner">
                        @if(count($empleadosListados) > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Legajo</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-4 py-2 text-right"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($empleadosListados as $index => $empleado)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $empleado->numero_legajo }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $empleado->persona->apellido }}, {{ $empleado->persona->nombre }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" wire:click="quitarEmpleado({{ $index }})" class="text-red-600 hover:text-red-900 font-bold text-xs bg-red-50 px-2 py-1 rounded hover:bg-red-100 transition">
                                                    Quitar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-4 text-center text-sm text-gray-400 italic">
                                No hay empleados asignados a esta solicitud.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones Generales</label>
                    <textarea wire:model.blur="form.observacion" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>

            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
           <button 
    type="button" 
    wire:click="save"
    wire:loading.attr="disabled"
    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg 
           shadow-md transform hover:-translate-y-0.5 transition duration-150 flex items-center">
    
    {{-- Texto normal --}}
    <span wire:loading.remove wire:target="save">
        Guardar Solicitud
    </span>

    {{-- Spinner mientras guarda --}}
    <span wire:loading wire:target="save" class="flex items-center">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Guardando...
    </span>
</button>

        </div>
    </form>

    @if ($showSuccessModal)
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
    >
        <div class="bg-white dark:bg-neutral-900 rounded-xl p-8 w-full max-w-md shadow-xl animate-fade-in">

            <div class="text-center">
                <svg class="w-16 h-16 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12l2 2l4 -4m6 2a10 10 0 1 1 -20 0a10 10 0 0 1 20 0z" />
                </svg>

                <h2 class="mt-4 text-2xl font-bold text-gray-800 dark:text-gray-100">
                    ¡Solicitud generada exitosamente!
                </h2>

                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    La solicitud fue creada correctamente. Ahora puedes visualizarla.
                </p>
            </div>

            <div class="mt-6 flex justify-center gap-3">

                <button 
                    wire:click="irAVisualizarSolicitud"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition"
                >
                    Ver solicitud
                </button>
            </div>
        </div>
    </div>
    @endif

</div>