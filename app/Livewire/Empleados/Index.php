<?php

namespace App\Livewire\Empleados;

use Livewire\Component;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Clase;
use App\Models\Departamento;
use App\Models\Distrito;

class Index extends Component
{
    public $empleados, $persona_id, $n_legajo, $asiento, $rol_id, $clase_id, $departamento_id, $selected_id;
    public $personas, $roles, $clases, $departamentos, $distritos;
    public $modal = false;

    public function render()
    {
        $this->empleados = Empleado::with(['persona', 'rol', 'clase', 'departamento', 'distrito'])->get();
        $this->personas = Persona::all();
        $this->roles = Rol::all();
        $this->clases = Clase::all();
        $this->departamentos = Departamento::all();
        $this->distritos = Distrito::all();

        return view('livewire.empleados.index');
    }

    public function create()
    {
        $this->resetFields();
        $this->modal = true;
    }

    public function store()
    {
        $this->validate([
            'persona_id' => 'required',
            'n_legajo' => 'required',
            'asiento' => 'required',
            'rol_id' => 'required',
            'clase_id' => 'required',
            'departamento_id' => 'required'
        ]);

        Empleado::updateOrCreate(['id_empleado' => $this->selected_id], [
            'id_persona' => $this->persona_id,
            'n_legajo' => $this->n_legajo,
            'asiento' => $this->asiento,
            'id_rol' => $this->rol_id,
            'id_clase' => $this->clase_id,
            'id_departamento' => $this->departamento_id
        ]);

        $this->modal = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $emp = Empleado::findOrFail($id);
        $this->selected_id = $id;
        $this->persona_id = $emp->id_persona;
        $this->n_legajo = $emp->n_legajo;
        $this->asiento = $emp->asiento;
        $this->rol_id = $emp->id_rol;
        $this->clase_id = $emp->id_clase;
        $this->departamento_id = $emp->id_departamento;
        $this->modal = true;
    }

    public function delete($id)
    {
        Empleado::findOrFail($id)->delete();
    }

    private function resetFields()
    {
        $this->reset(['persona_id', 'n_legajo', 'asiento', 'rol_id', 'clase_id', 'departamento_id', 'selected_id']);
    }
}
