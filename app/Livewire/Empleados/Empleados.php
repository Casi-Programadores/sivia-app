<?php

namespace App\Livewire\Empleados;

use Livewire\Component;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Clase;
use App\Models\Departamento;
use App\Models\Distrito;

class Empleados extends Component
{

    public $empleados, $personas, $roles, $clases, $departamentos, $distritos, $distrito_id;
    public $search = '';


    public $modal = false;
    public $selected_id;
    public $persona_id, $numero_legajo, $rol_id, $clase_id, $departamento_id;

    public function mount()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $this->empleados = Empleado::with(['persona', 'rol', 'clase', 'departamento'])
            ->when($this->search, function ($query) {
                $query->whereHas('persona', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('apellido', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        $this->personas = Persona::all();
        $this->roles = Rol::all();
        $this->clases = Clase::all();
        $this->departamentos = Departamento::all();
        $this->distritos = Distrito::all();
    }

    public function updatedSearch()
    {
        $this->loadData();
    }

    public function create()
    {
        if (!auth()->user()->isRole('admin')) return;

        $this->resetForm();
        $this->modal = true;
    }

    public function edit($id)
    {
        if (!auth()->user()->isRole('admin')) return;

        $empleado = Empleado::findOrFail((int)$id);

        $this->selected_id = $empleado->id; // <--- clave primaria correcta
        $this->persona_id = $empleado->persona_id;
        $this->numero_legajo = $empleado->numero_legajo;
        $this->rol_id = $empleado->rol_id;
        $this->clase_id = $empleado->clase_id;
        $this->departamento_id = $empleado->departamento_id;

        $this->modal = true;
    }

    public function store()
    {
        if (!auth()->user()->isRole('admin')) return;

        if (!$this->rol_id) {
            $this->rol_id = Rol::where('nombre_rol', 'Usuario')->first()->id;
        }


        $this->validate([
            'persona_id' => 'required',
            'numero_legajo' => 'required',
            'distrito_id' => 'required', // <-- cambiamos rol_id por distrito_id
            'clase_id' => 'nullable',
            'departamento_id' => 'required',
        ], [
            'persona_id.required' => 'Debes seleccionar una persona.',
            'numero_legajo.required' => 'El legajo es obligatorio.',
            'distrito_id.required' => 'Debes seleccionar un distrito.',
            'departamento_id.required' => 'Debes seleccionar un departamento.',
        ]);

        if ($this->selected_id) {
            // Actualizar
            $empleado = Empleado::find($this->selected_id);
            $empleado->update([
                'persona_id' => $this->persona_id,
                'numero_legajo' => $this->numero_legajo,
                'distrito_id' => $this->distrito_id, // <-- aquí también
                'clase_id' => $this->clase_id,
                'departamento_id' => $this->departamento_id,
            ]);
        } else {
            // Crear
            Empleado::create([
                'persona_id' => $this->persona_id,
                'numero_legajo' => $this->numero_legajo,
                'distrito_id' => $this->distrito_id, // <-- aquí también
                'clase_id' => $this->clase_id,
                'departamento_id' => $this->departamento_id,
                'rol_id' => $this->rol_id,
            ]);
        }

        $this->loadData();
        $this->resetForm();
        $this->modal = false;
    }


    public function delete($id)
    {
        if (!auth()->user()->isRole('admin')) return;

        $empleado = Empleado::findOrFail((int)$id);
        $empleado->delete();

        $this->loadData();
    }

    private function resetForm()
    {
        $this->selected_id = null;
        $this->persona_id = null;
        $this->numero_legajo = null;
        $this->rol_id = null;
        $this->clase_id = null;
        $this->departamento_id = null;
        $this->distrito_id = null;
    }

    public function render()
    {
        return view('livewire.empleados.empleado');
    }
}
