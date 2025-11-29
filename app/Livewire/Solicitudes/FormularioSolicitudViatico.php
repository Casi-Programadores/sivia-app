<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Livewire\Forms\SolicitudForm;
use App\Models\Empleado;
use App\Models\NumeroNotaInterna;
use App\Models\Porcentaje;
use App\Models\Distrito;
use App\Models\Localidad;

class FormularioSolicitudViatico extends Component
{
    public SolicitudForm $form;

    public $empleado_seleccionado_id = '';

    // Datos para selects
    public $notas_internas;
    public $porcentajes;
    public $distritos;
    public $localidades;
    public $todos_empleados;

    // Variables para controlar el modal
    public $showSuccessModal = false;
    public $solicitudGeneradaId = null;

    public function mount()
    {
        $this->form->reset();
        $this->notas_internas = NumeroNotaInterna::all();
        $this->porcentajes = Porcentaje::all();
        $this->distritos = Distrito::all();
        $this->localidades = Localidad::all();
        $this->todos_empleados = Empleado::with('persona')->get();
    }

    public function updated($propertyName)
    {
        if (
            str_contains($propertyName, 'form.cantidad_dias') ||
            str_contains($propertyName, 'form.monto') ||
            str_contains($propertyName, 'form.empleados_agregados') ||
            str_contains($propertyName, 'form.porcentaje_id')
        ) {
            $this->form->calcularTotal();
        }


        if ($propertyName === 'form.es_fuera_provincia' && !$this->form->es_fuera_provincia) {
            $this->form->nombre_provincia = null;
        }
    }

    public function agregarEmpleado()
    {
        $this->validate([
            'empleado_seleccionado_id' => 'required|exists:empleados,id'
        ]);

        if (!in_array($this->empleado_seleccionado_id, $this->form->empleados_agregados)) {
            $this->form->empleados_agregados[] = $this->empleado_seleccionado_id;
            $this->form->calcularTotal();
        }

        $this->reset('empleado_seleccionado_id');
    }

    public function quitarEmpleado($index)
    {
        unset($this->form->empleados_agregados[$index]);
        $this->form->empleados_agregados = array_values($this->form->empleados_agregados);
        $this->form->calcularTotal();
    }

    public function save()
    {
        // Guardar solicitud
        $solicitud = $this->form->store();

        // Guardamos el ID generado
        $this->solicitudGeneradaId = $solicitud->id;

        $this->form->resetValidation();

        // Mostrar modal
        $this->showSuccessModal = true;
    }

    public function irAVisualizarSolicitud()
    {
        return redirect()->route('solicitud.ver', $this->solicitudGeneradaId);
    }

    public function render()
    {
        $empleadosListados = [];

        if (!empty($this->form->empleados_agregados)) {
            $empleadosListados = Empleado::with('persona')
                ->whereIn('id', $this->form->empleados_agregados)
                ->get();
        }

        return view('livewire.solicitudes.formulario-solicitud-viatico', [
            'empleadosListados' => $empleadosListados
        ]);
    }
}
