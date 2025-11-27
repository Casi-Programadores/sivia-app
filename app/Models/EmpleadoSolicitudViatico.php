<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpleadoSolicitudViatico extends Model
{
    protected $table = 'empleado_solicitud_viatico';

    protected $fillable = [
        'solicitud_viatico_id',
        'empleado_id'
    ];

        public function solicitud()
    {
        return $this->belongsTo(SolicitudViatico::class, 'solicitud_viatico_id');
    }

    /**
     * Relación: este registro pertenece a un empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    use SoftDeletes;
}
