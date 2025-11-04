<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mesa_Entrada extends Model
{
    protected $table = 'mesa_entrada';
    use SoftDeletes;
}
