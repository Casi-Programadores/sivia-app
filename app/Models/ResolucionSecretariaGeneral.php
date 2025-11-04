<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resoluciones_Secretaria_General extends Model
{
    protected $table = 'resoluciones_secretaria_general';
    use SoftDeletes;
}
