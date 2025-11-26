<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $fillable = ['persona_id', 'numero_legajo', 'departamento_id','distrito_id', 'rol_id', 'clase_id'];
    

    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function departamento() {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function distrito() {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function rol() {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function clase() {
        return $this->belongsTo(Clase::class, 'clase_id');
    }
    
    use SoftDeletes;

}
