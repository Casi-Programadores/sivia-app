<div class="p-6 bg-gray-50 min-h-screen text-gray-900">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-black"> Empleados</h1>

        <div class="flex items-center space-x-3">
            <input type="text"
                wire:model.live="search"
                placeholder="Buscar por nombre o apellido..."
                class="px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900 w-64">

            @if(auth()->user()->isRole('admin'))
            <button wire:click="create"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm transition-all">
                + Nuevo Empleado
            </button>
            @endif
        </div>
    </div>


    <!-- Tabla -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-sm">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-black uppercase text-sm">
                    <th class="px-4 py-2">Legajo</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Clase</th>
                    <th class="px-4 py-2">Departamento</th>
                    @if(auth()->user()->isRole('admin'))
                    <th class="px-4 py-2 text-center">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($empleados as $e)
                <tr class="hover:bg-gray-50 text-black">
                    <td class="px-4 py-2">{{ $e->numero_legajo }}</td>
                    <td class="px-4 py-2">{{ $e->persona->nombre }} {{ $e->persona->apellido }}</td>
                    <td class="px-4 py-2">{{ $e->clase->numero_clase ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $e->departamento->departamento ?? '-' }}</td>

                    @if(auth()->user()->isRole('admin'))
                    <td class="px-4 py-2 text-center space-x-2">
                        <button wire:click="edit('{{ $e->id }}')"
                            class="text-blue-700 hover:text-blue-900 font-semibold">
                            Editar
                        </button>
                        <button wire:click="delete('{{ $e->id }}')"
                            class="text-red-700 hover:text-red-900 font-semibold">
                            Eliminar
                        </button>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->isRole('admin') ? 6 : 5 }}"
                        class="text-center text-gray-600 py-4 font-medium">
                        No hay empleados registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(auth()->user()->isRole('admin') && $modal)
    <div class="fixed inset-0 bg-gray-800 bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-gray-900">
            <h2 class="text-xl font-semibold mb-4 text-black">
                {{ $selected_id ? 'Editar' : 'Nuevo' }} Empleado
            </h2>

            <div class="space-y-3">
                <!-- Persona -->
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Persona</label>
                    <select wire:model="persona_id"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar...</option>
                        @foreach($personas as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->apellido }}</option>
                        @endforeach
                    </select>
                    @error('persona_id') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Legajo -->
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Legajo</label>
                    <input wire:model="numero_legajo" type="text"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                    @error('numero_legajo') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Distrito -->
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Distrito</label>
                    <select wire:model="distrito_id"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar...</option>
                        @foreach($distritos as $d)
                        <option value="{{ $d->id }}">{{ $d->distrito }}</option>
                        @endforeach
                    </select>
                    @error('distrito_id') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Rol -->
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Cargo</label>
                    <select wire:model="empleado_cargo_id"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar...</option>
                        @foreach($cargos as $c)
                        <option value="{{ $c->id }}">{{ $c->cargo }}</option>
                        @endforeach
                    </select>
                    @error('empleado_cargo_id') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <!-- Clase -->
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Clase</label>
                    <select wire:model="clase_id"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar...</option>
                        @foreach($clases as $c)
                        <option value="{{ $c->id }}">{{ $c->numero_clase }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Departamento -->
                <div>
                    <label class="block text-sm font-semibold text-black mb-1">Departamento</label>
                    <select wire:model="departamento_id"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar...</option>
                        @foreach($departamentos as $d)
                        <option value="{{ $d->id }}">{{ $d->departamento }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end mt-5 space-x-2">
                <button wire:click="$set('modal', false)"
                    class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg transition">
                    Cancelar
                </button>
                <button wire:click="store"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    Guardar
                </button>
            </div>
        </div>
    </div>
    @endif


</div>