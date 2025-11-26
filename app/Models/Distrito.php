<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distrito extends Model
{
    protected $table = 'distritos';
    protected $fillable = ['distrito'];
    use SoftDeletes;
}
