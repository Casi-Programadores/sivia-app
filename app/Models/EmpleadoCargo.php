<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoCargo extends Model
{

    protected $table = 'empleados_cargos';

    protected $fillable = [
        'cargo',
    ];

}