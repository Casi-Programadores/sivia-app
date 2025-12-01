<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Rule;
use App\Models\SolicitudViatico;
use App\Models\DetalleSolicitudViatico; 
use App\Models\EstadoSolicitud;
use App\Models\Porcentaje;
use Illuminate\Support\Facades\DB;

class SolicitudForm extends Form
{
    #[Rule('required|exists:numero_nota_interna,id')]
    public $numero_nota_interna_id;

    #[Rule('required|integer|min:1')]
    public $cantidad_dias = 1;

    #[Rule('required|exists:porcentajes,id')]
    public $porcentaje_id;

    // "Requerido si 'es_fuera_provincia' es falso (o sea, es local)"
    #[Rule('required_unless:es_fuera_provincia,true|nullable|exists:distritos,id', message: 'Distrito es obligatorio a menos que el destino sea fuera de la provincia.')]
    public $distrito_id;

   #[Rule('required_unless:es_fuera_provincia,true|nullable|exists:localidades,id', message: 'Localidad es obligatorio a menos que el destino sea fuera de la provincia.')]
    public $localidad_id;
    // -------------------------------------------

    #[Rule('required|numeric|min:0')]
    public $monto = 0;

    public $monto_total = 0; 

    // Validación de fecha: no anterior a hoy
    #[Rule('required|date|after_or_equal:today')]
    public $fecha_fin;

    #[Rule('required|string|max:255')]
    public $objeto_comision;

    #[Rule('nullable|string')]
    public $observacion;

    public $es_fuera_provincia = false; 
    
    #[Rule('required_if:es_fuera_provincia,true|nullable|string|max:100')]
    public $nombre_provincia;

    #[Rule('required|array|min:1', message: 'Debe agregar al menos un empleado a la solicitud.')]
    public $empleados_agregados = [];

    protected $validationAttributes = [
    'numero_nota_interna_id' => 'número de nota interna',
    'cantidad_dias'          => 'cantidad de días',
    'porcentaje_id'          => 'porcentaje de liquidación',
    'distrito_id'            => 'distrito',
    'localidad_id'           => 'localidad',
    'monto'                  => 'monto diario',
    'monto_total'            => 'monto total',
    'fecha_fin'              => 'fecha de fin',
    'objeto_comision'        => 'objeto de la comisión',
    'observacion'            => 'observación',
    'nombre_provincia'       => 'nombre de la provincia',
    'empleados_agregados'    => 'empleados agregados',
];


    public function calcularTotal()
    {
        $dias = (int) $this->cantidad_dias;
        $montoBase = (float) $this->monto;
        $cantidadPersonas = count($this->empleados_agregados);
        $factorPersonas = $cantidadPersonas > 0 ? $cantidadPersonas : 0;

        $valorPorcentaje = 100; // Por defecto
        
        if ($this->porcentaje_id) {
            $pct = Porcentaje::find($this->porcentaje_id);
            if ($pct) {
                $valorPorcentaje = (float) $pct->porcentaje;
            }
        }

        // 2. Aplicamos la fórmula:
        // (Monto Diario * (Porcentaje / 100)) * Días * Personas
        $montoDiarioAjustado = $montoBase * ($valorPorcentaje / 100);

        $this->monto_total = ($montoDiarioAjustado * $dias) * $factorPersonas;
    }

    public function store()
    {
        $this->validate();

        $solicitud = null;

        DB::transaction(function () use (&$solicitud) {

            $solicitud = SolicitudViatico::create([
                'numero_nota_interna_id' => $this->numero_nota_interna_id,
                'cantidad_dias'          => $this->cantidad_dias,
                'porcentaje_id'          => $this->porcentaje_id,
                'distrito_id' => $this->es_fuera_provincia ? null : $this->distrito_id,
                'localidad_id' => $this->es_fuera_provincia ? null : $this->localidad_id,                
                'monto'                  => $this->monto,
                'monto_total'            => $this->monto_total,
                'fecha_fin'              => $this->fecha_fin,
                'objeto_comision'        => $this->objeto_comision,
                'observacion'            => $this->observacion,
                'provincia'              => $this->es_fuera_provincia ? $this->nombre_provincia : null,
            ]);

            $solicitud->empleados()->attach($this->empleados_agregados);

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