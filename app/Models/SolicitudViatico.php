<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudViatico extends Model
{
        protected $fillable = [
        'numero_nota_interna_id',
        'cantidad_dias',
        'porcentaje_id',
        'distrito_id',
        'localidad_id',
        'monto',
        'monto_total',
        'fecha_fin',
        'objeto_comision',
        'observacion',
        'provincia',
    ];

        // Relaciones
    public function numeroNotaInterna()
    {
        return $this->belongsTo(NumeroNotaInterna::class, 'numero_nota_interna_id');
    }

    public function porcentaje()
    {
        return $this->belongsTo(Porcentaje::class);
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    // Many-to-Many con Empleado (pivot empleado_solicitud_viatico)
    public function empleados()
    {
        return $this->belongsToMany(
            Empleado::class,
            'empleado_solicitud_viatico',
            'solicitud_viatico_id',
            'empleado_id'
        )->withTimestamps();
    }

    // One-to-One al detalle
    public function detalle()
    {
        return $this->hasOne(DetalleSolicitudViatico::class, 'solicitud_viatico_id');
    }

    protected $table = 'solicitudes_viaticos';
    use SoftDeletes;
}
