<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleSolicitudViatico extends Model
{
    protected $table = 'detalles_solicitud_viaticos';

    use SoftDeletes;
}
