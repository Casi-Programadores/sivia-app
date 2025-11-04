<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadosSolicitud extends Model
{
    protected $table = 'estados_solicitud';
    use SoftDeletes;
}
