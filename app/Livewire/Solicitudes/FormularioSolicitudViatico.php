<?php

namespace App\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\SolicitudViatico;
use App\Models\Empleado;
use App\Models\NumeroNotaInterna;
use App\Models\Porcentaje;
use App\Models\Distrito;
use App\Models\Localidad;
use Illuminate\Support\Collection;

class FormularioSolicitudViatico extends Component
{
    // Propiedades del Formulario (Modelo SolicitudViatico)
    public $numero_nota_interna_id;
    public $cantidad_dias = 1;
    public $porcentaje_id;
    public $distrito_id;
    public $localidad_id;
    public $monto = 0; // Monto Base Diario
    public $monto_total = 0; // Calculado
    public $fecha_fin;
    public $objeto_comision;
    public $observacion;
    
    // Lógica de Provincia (UI)
    public $es_fuera_provincia = false; // Checkbox UI
    public $nombre_provincia; // Campo string 'provincia' en BD

    // Lógica de Empleados (Array dinámico)
    public $empleado_seleccionado_id; // El valor del select temporal
    public $empleados_agregados = []; // Array de IDs de empleados añadidos

    // Colecciones para los Selects
    public $notas_internas;
    public $porcentajes;
    public $distritos;
    public $localidades;
    public $todos_empleados;

    protected function rules()
    {
        return [
            'numero_nota_interna_id' => 'required|exists:numero_nota_interna,id',
            'cantidad_dias'          => 'required|integer|min:1',
            'porcentaje_id'          => 'required|exists:porcentajes,id',
            'distrito_id'            => 'required|exists:distritos,id',
            'localidad_id'           => 'required|exists:localidades,id',
            'monto'                  => 'required|numeric|min:0',
            'fecha_fin'              => 'required|date',
            'objeto_comision'        => 'required|string|max:255',
            'observacion'            => 'nullable|string',
            // Si es fuera de provincia, el nombre es obligatorio
            'nombre_provincia'       => $this->es_fuera_provincia ? 'required|string|max:100' : 'nullable',
            // Validar que haya al menos 1 empleado
            'empleados_agregados'    => 'required|array|min:1', 
        ];
    }

    public function mount()
    {
        // Cargar datos estáticos para los selects
        $this->notas_internas = NumeroNotaInterna::all();
        $this->porcentajes = Porcentaje::all();
        $this->distritos = Distrito::all();
        $this->localidades = Localidad::all();
        
        // Cargamos empleados con su relación persona para mostrar Nombre
        $this->todos_empleados = Empleado::with('persona')->get();
    }

    // Hook: Se ejecuta cada vez que una propiedad cambia
    public function updated($propertyName)
    {
        // Validación en tiempo real solo del campo modificado
        $this->validateOnly($propertyName);

        // Recalcular total si cambian los factores
        if (in_array($propertyName, ['cantidad_dias', 'monto'])) {
            $this->calcularTotal();
        }

        // Resetear nombre provincia si se desmarca el check
        if ($propertyName === 'es_fuera_provincia' && !$this->es_fuera_provincia) {
            $this->nombre_provincia = null;
        }
    }

    // Método para agregar empleado a la lista temporal
    public function agregarEmpleado()
    {
        $this->validate([
            'empleado_seleccionado_id' => 'required|exists:empleados,id'
        ]);

        // Evitar duplicados
        if (!in_array($this->empleado_seleccionado_id, $this->empleados_agregados)) {
            $this->empleados_agregados[] = $this->empleado_seleccionado_id;
            $this->calcularTotal(); // Recalcular al agregar persona
        }

        $this->reset('empleado_seleccionado_id');
    }

    // Método para quitar empleado de la lista
    public function quitarEmpleado($index)
    {
        unset($this->empleados_agregados[$index]);
        $this->empleados_agregados = array_values($this->empleados_agregados); // Reindexar array
        $this->calcularTotal(); // Recalcular al quitar persona
    }

    public function calcularTotal()
    {
        $dias = (int) $this->cantidad_dias;
        $montoBase = (float) $this->monto;
        $cantidadPersonas = count($this->empleados_agregados);

        // Fórmula: (Monto Base * Días) * Cantidad de Personas
        $this->monto_total = ($montoBase * $dias) * ($cantidadPersonas > 0 ? $cantidadPersonas : 0);
    }

    public function save()
    {
        $this->validate();

        // 1. Crear la Solicitud
        $solicitud = SolicitudViatico::create([
            'numero_nota_interna_id' => $this->numero_nota_interna_id,
            'cantidad_dias'          => $this->cantidad_dias,
            'porcentaje_id'          => $this->porcentaje_id,
            'distrito_id'            => $this->distrito_id,
            'localidad_id'           => $this->localidad_id,
            'monto'                  => $this->monto,
            'monto_total'            => $this->monto_total,
            'fecha_fin'              => $this->fecha_fin,
            'objeto_comision'        => $this->objeto_comision,
            'observacion'            => $this->observacion,
            'provincia'              => $this->nombre_provincia, // Guarda el string o null
        ]);

        // 2. Llenar tabla pivote (empleado_solicitud_viatico)
        // sync() o attach() funcionan igual para creación.
        $solicitud->empleados()->attach($this->empleados_agregados);

        // 3. Feedback y Limpieza
        session()->flash('message', 'Solicitud creada exitosamente con ' . count($this->empleados_agregados) . ' empleados.');
        
        $this->reset(['monto', 'monto_total', 'objeto_comision', 'observacion', 'empleados_agregados', 'nombre_provincia', 'es_fuera_provincia']);
    }

    public function render()
    {
        // Necesitamos recuperar los objetos Empleado completos para mostrar nombres en la lista "agregados"
        $empleadosListados = Empleado::with('persona')
            ->whereIn('id', $this->empleados_agregados)
            ->get();

        return view('livewire.solicitudes.formulario-solicitud-viatico', [
            'empleadosListados' => $empleadosListados
        ]);
    }
}