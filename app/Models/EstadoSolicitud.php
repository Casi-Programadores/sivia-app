<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estados_Solicitud extends Model
{
    protected $table = 'estados_solicitud';
    use SoftDeletes;
}
