<?php

namespace App\Livewire\Certificaciones;

use Livewire\Component;
use App\Models\SolicitudViatico;
use App\Models\ResolucionSecretariaGeneral;
use App\Models\MesaEntrada;
use App\Models\DetalleSolicitudViatico;
use App\Models\EstadoSolicitud;
use Illuminate\Support\Facades\DB;

class FormularioCertificacion extends Component
{
    public SolicitudViatico $solicitud;

    // Datos del Formulario
    public $numero_resolucion;
    public $fecha_resolucion;
    public $letra;
    public $numero_expediente;

    // Control de UI
    public $empleados = [];
    
    // Estados de la vista
    public $showConfirmationModal = false;
    public $certificacionRealizada = false; 

    protected $rules = [
        'numero_resolucion' => 'required|integer|unique:resoluciones_secretaria_general,numero_resolucion',
        'fecha_resolucion'  => 'required|date',
        'letra'             => 'required|string|max:5', 
        'numero_expediente' => 'required|integer|unique:mesas_entradas,numero_expediente',
    ];

public function mount($id)
    {
        $this->solicitud = SolicitudViatico::with(['empleados.persona', 'numeroNotaInterna', 'detalle'])->findOrFail($id);
        
        // --- BLOQUEO DE SEGURIDAD ---
        // Si la solicitud ya tiene estado 2 (Aprobada), no dejamos entrar aquí de nuevo.
        // Asumiendo que el ID 2 es Aprobada. Ajusta si usas otro ID.
        if ($this->solicitud->detalle && $this->solicitud->detalle->estado_solicitud_id == 2) {
            // Opcional: Puedes mandar un mensaje flash
            session()->flash('message', 'Esa solicitud ya fue certificada anteriormente.');
            return redirect()->route('dashboard');
        }
        // -----------------------------

        $this->empleados = $this->solicitud->empleados;
        $this->fecha_resolucion = now()->format('Y-m-d');
    }

    public function confirmarOperacion()
    {
        $this->validate();
        $this->showConfirmationModal = true;
    }

    public function certificar()
    {
        $this->showConfirmationModal = false;

        DB::transaction(function () {
            // 1. Guardar Resolución
            $resolucion = ResolucionSecretariaGeneral::create([
                'numero_resolucion' => $this->numero_resolucion,
                'fecha_resolucion'  => $this->fecha_resolucion,
            ]);

            // 2. Guardar Mesa de Entrada
            $mesa = MesaEntrada::create([
                'letra'             => strtoupper($this->letra),
                'numero_expediente' => $this->numero_expediente,
            ]);

            // 3. Estado Aprobada
            $estadoAprobado = EstadoSolicitud::where('nombre_estado', 'Aprobada')->first();

            // 4. Actualizar Detalles
            DetalleSolicitudViatico::updateOrCreate(
                ['solicitud_viatico_id' => $this->solicitud->id],
                [
                    'estado_solicitud_id' => $estadoAprobado->id,
                    'mesa_entrada_id'     => $mesa->id,
                    'resolucion_id'       => $resolucion->id,
                ]
            );
        });

        $this->certificacionRealizada = true;
        
        $this->reset(['numero_resolucion', 'letra', 'numero_expediente']);
    }

    public function finalizar()
    {
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.certificaciones.formulario-certificacion');
    }
}