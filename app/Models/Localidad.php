<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localidad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'localidades';

    /**
     * Columnas que se pueden llenar masivamente
     */
    protected $fillable = [
        'nombre_localidades',
    ];

    /**
     * Relaciones
     */

    public function solicitudesViaticos()
    {
        return $this->hasMany(SolicitudViatico::class, 'localidad_id');
    }
}
