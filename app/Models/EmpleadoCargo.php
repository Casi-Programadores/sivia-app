<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoCargo extends Model
{

    protected $table = 'empleados_cargos';

    protected $fillable = [
        'cargo',
    ];

        public function empleados()
    {
        return $this->hasMany(Empleado::class, 'empleado_cargo_id');
    }
}