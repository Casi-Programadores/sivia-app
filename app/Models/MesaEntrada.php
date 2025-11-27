<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MesaEntrada extends Model
{
    protected $fillable = [
        'letra', 'numero_expediente'
    ];

    protected $table = 'mesa_entrada';
    use SoftDeletes;
}
