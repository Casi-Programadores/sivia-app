<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use App\Models\SolicitudViatico;
use App\Models\DetalleSolicitudViatico; 
use App\Models\EstadoSolicitud;
use Illuminate\Support\Facades\DB;

class SolicitudForm extends Form
{
    // Definimos las reglas directamente en las propiedades (Novedad de Livewire 3)
    
    #[Rule('required|exists:numero_nota_interna,id')]
    public $numero_nota_interna_id;

    #[Rule('required|integer|min:1')]
    public $cantidad_dias = 1;

    #[Rule('required|exists:porcentajes,id')]
    public $porcentaje_id;

    #[Rule('required|exists:distritos,id')]
    public $distrito_id;

    #[Rule('required|exists:localidades,id')]
    public $localidad_id;

    #[Rule('required|numeric|min:0')]
    public $monto = 0;

    // Calculado (readonly), no requiere validación de entrada
    public $monto_total = 0; 

    #[Rule('required|date|after_or_equal:today')]
    public $fecha_fin;

    #[Rule('required|string|max:255')]
    public $objeto_comision;

    #[Rule('nullable|string')]
    public $observacion;

    // Lógica de provincia
    public $es_fuera_provincia = false; 
    
    #[Rule('required_if:es_fuera_provincia,true|nullable|string|max:100')]
    public $nombre_provincia;

    // Empleados (Array)
    #[Rule('required|array|min:1', message: 'Debe agregar al menos un empleado a la solicitud.')]
    public $empleados_agregados = [];

    // --- MÉTODOS DE LÓGICA ---

    public function calcularTotal()
    {
        $dias = (int) $this->cantidad_dias;
        $montoBase = (float) $this->monto;
        $cantidadPersonas = count($this->empleados_agregados);


        $factorPersonas = $cantidadPersonas > 0 ? $cantidadPersonas : 0;

        $this->monto_total = ($montoBase * $dias) * $factorPersonas;
    }

    public function store()
    {
        $this->validate();

        // Variable donde guardaremos la solicitud creada
        $solicitud = null;

        DB::transaction(function () use (&$solicitud) {

            // 1. Crear la Solicitud Principal
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
                'provincia'              => $this->es_fuera_provincia ? $this->nombre_provincia : null,
            ]);

            // 2. Asociar empleados
            $solicitud->empleados()->attach($this->empleados_agregados);

            // 3. Estado inicial “Pendiente”
            $estadoPendiente = EstadoSolicitud::firstOrCreate([
                'nombre_estado' => 'Pendiente'
            ]);

            DetalleSolicitudViatico::create([
                'solicitud_viatico_id' => $solicitud->id,
                'estado_solicitud_id'  => $estadoPendiente->id,
                'mesa_entrada_id'      => null,
                'resolucion_id'        => null,
            ]);
        });

        return $solicitud;
    }

}