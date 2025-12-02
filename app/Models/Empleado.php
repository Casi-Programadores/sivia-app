<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $table = 'empleados';

    // Indicar la PK correcta
    protected $primaryKey = 'id';
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'persona_id', 
        'numero_legajo', 
        'departamento_id',
        'distrito_id', 
        'empleado_cargo_id', 
        'clase_id'
    ];

    // Relaciones
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function departamento() {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distrito() {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function cargo()
    {
        return $this->belongsTo(EmpleadoCargo::class, 'empleado_cargo_id');
    }


    public function clase() {
        return $this->belongsTo(Clase::class, 'clase_id');
    }

    public function solicitudesViaticos()
    {
        return $this->belongsToMany(
            SolicitudViatico::class,
            'empleado_solicitud_viatico',
            'empleado_id',
            'solicitud_viatico_id'
        )->withTimestamps();
    }
}
