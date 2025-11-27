<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    protected $fillable = ['departamento'];
    protected $table = 'departamentos';
    use SoftDeletes;
}
