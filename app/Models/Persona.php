<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = ['nombre', 'apellido', 'dni'];

    public function empleados() {
        return $this->hasMany(Empleado::class, 'id_persona');
    }

    use SoftDeletes;
}
