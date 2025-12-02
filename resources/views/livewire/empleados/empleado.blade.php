<div class="p-6 bg-gray-50 min-h-screen font-sans text-slate-600">

    {{-- HEADER Y BUSCADOR --}}
    <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
        
        <div>
            <h1 class="text-2xl font-bold text-[#1e3a8a]">Gestión de Empleados</h1>
            <p class="text-sm text-gray-500 mt-1">Administre el personal, legajos y departamentos.</p>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            {{-- Buscador --}}
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input 
                    type="text"
                    wire:model.live="search"
                    placeholder="Buscar empleado..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:ring-[#1e3a8a] focus:border-[#1e3a8a] shadow-sm"
                >
            </div>

            {{-- Botón Nuevo --}}
            @if(auth()->user()->isRole('admin'))
                <button 
                    wire:click="create"
                    class="bg-[#1e3a8a] hover:bg-[#152c6e] text-white px-5 py-2.5 rounded-lg shadow-md transition-all flex items-center gap-2 text-sm font-bold shrink-0"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nuevo
                </button>
            @endif
        </div>
    </div>

    {{-- TABLA DE EMPLEADOS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Legajo</th>
                        <th scope="col" class="px-6 py-4 font-bold">Nombre Completo</th>
                        <th scope="col" class="px-6 py-4 font-bold">Clase</th>
                        <th scope="col" class="px-6 py-4 font-bold">Departamento</th>
                        <th scope="col" class="px-6 py-4 font-bold">Cargo</th>
                        @if(auth()->user()->isRole('admin'))
                            <th scope="col" class="px-6 py-4 font-bold text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($empleados as $e)
                        <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                            
                            {{-- Legajo (Estilo Badge) --}}
                            <td class="px-6 py-4">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-mono font-bold border border-gray-200">
                                    {{ $e->numero_legajo }}
                                </span>
                            </td>

                            {{-- Nombre --}}
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ $e->persona->apellido }}, {{ $e->persona->nombre }}
                            </td>

                            {{-- Clase --}}
                            <td class="px-6 py-4">
                                {{ $e->clase->numero_clase ?? '-' }}
                            </td>

                            {{-- Departamento --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $e->departamento->departamento ?? '-' }}
                            </td>

                            {{-- Cargo --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $e->cargo->cargo ?? '-' }}
                            </td>

                            {{-- Acciones --}}
                            @if(auth()->user()->isRole('admin'))
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- Botón Editar --}}
                                        <button wire:click="edit('{{ $e->id }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>

                                        {{-- Botón Eliminar --}}
                                        <button 
                                            wire:click="confirmDelete('{{ $e->id }}')" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Dar de Baja"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isRole('admin') ? 6 : 5 }}" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p>No se encontraron empleados registrados.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Paginación --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $empleados->links() }}
        </div>
    </div>

    {{-- MODAL FORMULARIO (Crear/Editar) --}}
    @if(auth()->user()->isRole('admin') && $modal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            {{-- Backdrop borroso --}}
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('modal', false)"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all scale-100 max-h-[90vh] overflow-y-auto">
                
                {{-- Header Modal --}}
                <div class="bg-[#1e3a8a] p-5 flex justify-between items-center sticky top-0 z-10">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $selected_id ? 'Editar Empleado' : 'Nuevo Empleado' }}
                    </h2>
                    <button wire:click="$set('modal', false)" class="text-blue-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Body Modal --}}
                <div class="p-6 space-y-6">
                    
                    {{-- SECCIÓN 1: DATOS PERSONALES --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-bold text-[#1e3a8a] uppercase mb-3 border-b border-gray-200 pb-1">Datos Personales</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Nombre --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                                <input wire:model="nombre" type="text" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                @error('nombre') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            {{-- Apellido --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Apellido</label>
                                <input wire:model="apellido" type="text" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                @error('apellido') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- DNI --}}
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">DNI</label>
                                <input wire:model="dni" type="text" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                @error('dni') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 2: DATOS LABORALES --}}
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h3 class="text-sm font-bold text-[#1e3a8a] uppercase mb-3 border-b border-blue-200 pb-1">Datos Laborales</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Legajo --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Número de Legajo</label>
                                <input wire:model="numero_legajo" type="text" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                @error('numero_legajo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Cargo --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Cargo</label>
                                <select wire:model="empleado_cargo_id" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                    <option value="">Seleccionar...</option>
                                    @foreach($cargos as $c)
                                        <option value="{{ $c->id }}">{{ $c->cargo }}</option> 
                                    @endforeach
                                </select>
                                @error('empleado_cargo_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Distrito --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Distrito</label>
                                <select wire:model="distrito_id" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                    <option value="">Seleccionar...</option>
                                    @foreach($distritos as $d)
                                        <option value="{{ $d->id }}">{{ $d->distrito }}</option>
                                    @endforeach
                                </select>
                                @error('distrito_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Clase --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Clase</label>
                                <select wire:model="clase_id" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                    <option value="">Seleccionar...</option>
                                    @foreach($clases as $c)
                                        <option value="{{ $c->id }}">{{ $c->numero_clase }}</option>
                                    @endforeach
                                </select>
                                @error('clase_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Departamento (Ocupa 2 columnas) --}}
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Departamento</label>
                                <select wire:model="departamento_id" class="w-full rounded-lg border-gray-300 focus:border-[#1e3a8a] focus:ring-[#1e3a8a] py-2 shadow-sm text-sm">
                                    <option value="">Seleccionar...</option>
                                    @foreach($departamentos as $d)
                                        <option value="{{ $d->id }}">{{ $d->departamento }}</option>
                                    @endforeach
                                </select>
                                @error('departamento_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer Modal --}}
                <div class="p-5 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 sticky bottom-0">
                    <button wire:click="$set('modal', false)" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button wire:click="store" class="px-6 py-2 bg-[#1e3a8a] text-white rounded-lg text-sm font-bold hover:bg-[#152c6e] shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar Todo
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL DE CONFIRMACIÓN DE BAJA --}}
    @if($confirmingDeletion)
        <div class="fixed inset-0 z-[60] flex items-center justify-center">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('confirmingDeletion', false)"></div>

            <div class="relative bg-white rounded-xl p-6 w-full max-w-sm shadow-2xl border-t-4 border-red-600 transform transition-all scale-100">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-2">¿Dar de baja al empleado?</h3>
                    
                    <p class="text-sm text-gray-600 mb-6">
                        Esta acción eliminará el registro del sistema. <br>
                        <span class="font-bold text-red-500">Esta acción no se puede deshacer.</span>
                    </p>

                    <div class="flex gap-3 justify-center">
                        <button 
                            wire:click="$set('confirmingDeletion', false)" 
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-200 transition"
                        >
                            Cancelar
                        </button>
                        
                        <button 
                            wire:click="delete" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 shadow-md transition flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Sí, dar de baja
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>