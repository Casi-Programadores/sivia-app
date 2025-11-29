<?php

namespace App\Livewire\Empleados;

use Livewire\Component;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Clase;
use App\Models\Departamento;

class Empleados extends Component
{
    public $empleados;
    public $personas, $roles, $clases, $departamentos;

    public $modal = false;
    public $selected_id;
    public $persona_id, $numero_legajo, $rol_id, $clase_id, $departamento_id;

    public function mount()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $this->empleados = Empleado::with(['persona', 'rol', 'clase', 'departamento'])->get();
        $this->personas = Persona::all();
        $this->roles = Rol::all();
        $this->clases = Clase::all();
        $this->departamentos = Departamento::all();
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

        $this->validate([
            'persona_id' => 'required',
            'numero_legajo' => 'required',
            'rol_id' => 'nullable',
            'clase_id' => 'nullable',
            'departamento_id' => 'nullable',
        ]);

        if ($this->selected_id) {
            // Actualizar
            $empleado = Empleado::find($this->selected_id);
            $empleado->update([
                'persona_id' => $this->persona_id,
                'numero_legajo' => $this->numero_legajo,
                'rol_id' => $this->rol_id,
                'clase_id' => $this->clase_id,
                'departamento_id' => $this->departamento_id,
            ]);
        } else {
            // Crear
            Empleado::create([
                'persona_id' => $this->persona_id,
                'numero_legajo' => $this->numero_legajo,
                'rol_id' => $this->rol_id,
                'clase_id' => $this->clase_id,
                'departamento_id' => $this->departamento_id,
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
    }

    public function render()
    {
        return view('livewire.empleados.empleado');
    }
}
