<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonaSolicitudViatico extends Model
{
    protected $table = 'personas_solicitud_viaticos';
    use SoftDeletes;
}
