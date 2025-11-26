<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudViatico extends Model
{
    protected $table = 'solicitudes_viaticos';
    use SoftDeletes;
}
