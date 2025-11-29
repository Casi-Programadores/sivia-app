<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleSolicitudViatico extends Model
{
    protected $table = 'detalles_solicitudes_viaticos';

    protected $fillable = [
        'estado_solicitud_id',
        'solicitud_viatico_id',
        'mesa_entrada_id',
        'resolucion_id',
    ];

        public function solicitud()
    {
        return $this->belongsTo(SolicitudViatico::class, 'solicitud_viatico_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoSolicitud::class, 'estado_solicitud_id');
    }

    public function mesaEntrada()
    {
        return $this->belongsTo(MesaEntrada::class, 'mesa_entrada_id');
    }

    public function resolucion()
    {
        return $this->belongsTo(ResolucionSecretariaGeneral::class, 'resolucion_id');
    }
    
    use SoftDeletes;
}
