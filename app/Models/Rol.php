<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nombre_rol'];
    use SoftDeletes;
}
