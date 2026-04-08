<?php

namespace App\Models;

use Database\Factories\SolicitudEquipoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud_Equipo extends Model
{
    /** @use HasFactory<SolicitudEquipoFactory> */
    use HasFactory;

    protected $fillable = [
        'id_solicitud',
        'id_unidad_equipo',
    ];

    public function unidad_equipo()
    {
        return $this->belongsTo(Unidad_Equipo::class, 'id_unidad_equipo');
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud');
    }
}
