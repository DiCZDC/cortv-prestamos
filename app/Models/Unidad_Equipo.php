<?php

namespace App\Models;

use Database\Factories\UnidadEquipoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad_Equipo extends Model
{
    /** @use HasFactory<UnidadEquipoFactory> */
    use HasFactory;

    protected $fillable = [
        'id_equipo',
        'sicipo',
        'estado',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }
}
