<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoSolicitud extends Model
{
     protected $fillable = [
        'nombre_estado',
    ];

    protected $table = 'estados_solicitudes';
    use SoftDeletes;
}
