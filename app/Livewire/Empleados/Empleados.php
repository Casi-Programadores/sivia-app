<?php

namespace App\Livewire\Empleados;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Distrito;
use App\Models\Clase;
use App\Models\Departamento;
use App\Models\EmpleadoCargo; 
use Illuminate\Support\Facades\DB;

class Empleados extends Component
{
    use WithPagination;

    // Propiedades del Empleado
    public $numero_legajo;
    public $distrito_id;
    public $clase_id;
    public $departamento_id;
    public $empleado_cargo_id; 
    
    // Propiedades de la Persona
    public $nombre;
    public $apellido;
    public $dni;

    // Control de Modal y borrado
    public $modal = false;
    public $selected_id;
    public $search = '';
    
    public $confirmingDeletion = false;
    public $employeeIdToDelete = null;

    protected function rules()
    {
        return [
            // Validación Persona
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni'      => 'required|string|max:20|unique:personas,dni,' . ($this->selected_id ? Empleado::find($this->selected_id)->persona_id : 'NULL'),

            // Validación Empleado
            'numero_legajo'     => 'required|string|max:50|unique:empleados,numero_legajo,' . $this->selected_id,
            'distrito_id'       => 'required|exists:distritos,id',
            'clase_id'          => 'required|exists:clases,id',
            'departamento_id'   => 'required|exists:departamentos,id',
            'empleado_cargo_id' => 'required|exists:empleados_cargos,id', 
        ];
    }

    public function render()
    {
        
        $empleados = Empleado::with(['persona', 'clase', 'departamento', 'cargo']) 
            ->whereHas('persona', function($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('apellido', 'like', '%' . $this->search . '%')
                  ->orWhere('dni', 'like', '%' . $this->search . '%');
            })
            ->orWhere('numero_legajo', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.empleados.empleado', [
            'empleados'     => $empleados,
            'distritos'     => Distrito::all(),
            'clases'        => Clase::all(),
            'departamentos' => Departamento::all(),
            'cargos'        => EmpleadoCargo::all(), // <--- CAMBIO AQUÍ
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetExcept(['modal', 'search']); 
        $this->modal = true;
        $this->selected_id = null;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $record = Empleado::with('persona')->findOrFail($id);

        $this->selected_id = $id;
        
        // Cargamos datos del Empleado
        $this->numero_legajo     = $record->numero_legajo;
        $this->distrito_id       = $record->distrito_id;
        $this->clase_id          = $record->clase_id;
        $this->departamento_id   = $record->departamento_id;
        $this->empleado_cargo_id = $record->empleado_cargo_id; // <--- CAMBIO AQUÍ

        // Cargamos datos de la Persona asociada
        $this->nombre   = $record->persona->nombre;
        $this->apellido = $record->persona->apellido;
        $this->dni      = $record->persona->dni;

        $this->modal = true;
    }

    public function store()
    {
        $this->validate();

        DB::transaction(function () {
            
            // 1. Crear o Actualizar Persona
            if ($this->selected_id) {
                $empleado = Empleado::find($this->selected_id);
                $persona = $empleado->persona;
                $persona->update([
                    'nombre'   => $this->nombre,
                    'apellido' => $this->apellido,
                    'dni'      => $this->dni,
                ]);
            } else {
                $persona = Persona::create([
                    'nombre'   => $this->nombre,
                    'apellido' => $this->apellido,
                    'dni'      => $this->dni,
                ]);
            }

            // 2. Crear o Actualizar Empleado
            Empleado::updateOrCreate(
                ['id' => $this->selected_id], 
                [
                    'persona_id'        => $persona->id,
                    'numero_legajo'     => $this->numero_legajo,
                    'distrito_id'       => $this->distrito_id,
                    'clase_id'          => $this->clase_id,
                    'departamento_id'   => $this->departamento_id,
                    'empleado_cargo_id' => $this->empleado_cargo_id, 
                ]
            );
        });

        $this->modal = false;
        session()->flash('message', $this->selected_id ? 'Empleado actualizado.' : 'Empleado creado exitosamente.');
        $this->resetExcept(['search']);
    }

    public function confirmDelete($id)
    {
        $this->employeeIdToDelete = $id;
        $this->confirmingDeletion = true;
    }

    public function delete()
    {
        $empleado = Empleado::find($this->employeeIdToDelete);
        if($empleado) {
            // Opcional: Borrar persona también si es necesario
            // $empleado->persona->delete(); 
            $empleado->delete();
            session()->flash('message', 'Empleado dado de baja correctamente.');
        }

        $this->confirmingDeletion = false;
        $this->employeeIdToDelete = null;
    }
}