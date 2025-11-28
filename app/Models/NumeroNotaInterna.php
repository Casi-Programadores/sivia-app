<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumeroNotaInterna extends Model
{
    protected $table = 'numero_nota_interna';
    protected $fillable = ['numero'];
    use SoftDeletes;
}
