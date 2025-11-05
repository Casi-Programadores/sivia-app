<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Gestión de Empleados</h1>

    <button wire:click="create" class="bg-blue-500 text-white px-3 py-1 rounded">Nuevo Empleado</button>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th>Legajo</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Clase</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $e)
            <tr>
                <td>{{ $e->n_legajo }}</td>
                <td>{{ $e->persona->nombre }} {{ $e->persona->apellido }}</td>
                <td>{{ $e->rol->numero ?? '-' }}</td>
                <td>{{ $e->clase->numero ?? '-' }}</td>
                <td>{{ $e->departamento->nombre ?? '-' }}</td>
                <td>
                    <button wire:click="edit({{ $e->id_empleado }})" class="text-blue-600">Editar</button>
                    <button wire:click="delete({{ $e->id_empleado }})" class="text-red-600 ml-2">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($modal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-4 rounded shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-3">{{ $selected_id ? 'Editar' : 'Nuevo' }} Empleado</h2>

            <div class="mb-2">
                <label>Persona</label>
                <select wire:model="persona_id" class="w-full border rounded">
                    <option value="">Seleccionar...</option>
                    @foreach($personas as $p)
                        <option value="{{ $p->id_persona }}">{{ $p->nombre }} {{ $p->apellido }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label>Legajo</label>
                <input wire:model="n_legajo" class="w-full border rounded">
            </div>

            <div class="mb-2">
                <label>Rol</label>
                <select wire:model="rol_id" class="w-full border rounded">
                    <option value="">Seleccionar...</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->id_rol }}">{{ $r->numero }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label>Clase</label>
                <select wire:model="clase_id" class="w-full border rounded">
                    <option value="">Seleccionar...</option>
                    @foreach($clases as $c)
                        <option value="{{ $c->id_clase }}">{{ $c->numero }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label>Departamento</label>
                <select wire:model="departamento_id" class="w-full border rounded">
                    <option value="">Seleccionar...</option>
                    @foreach($departamentos as $d)
                        <option value="{{ $d->id_departamento }}">{{ $d->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button wire:click="$set('modal', false)" class="px-3 py-1 bg-gray-400 text-white rounded">Cancelar</button>
                <button wire:click="store" class="px-3 py-1 bg-green-600 text-white rounded ml-2">Guardar</button>
            </div>
        </div>
    </div>
    @endif
</div>
