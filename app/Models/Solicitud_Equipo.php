<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud_Equipo extends Model
{
    /** @use HasFactory<\Database\Factories\SolicitudEquipoFactory> */
    use HasFactory;
    protected $fillable = [
        'equipo_id',
        'usuario_id',
        'fecha_solicitud',
        'fecha_devolucion',
        'estado',
    ];

    public function unidad_equipo()
    {
        return $this->belongsTo(Unidad_Equipo::class, 'id_unidad_Equipo');
    }
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud');
    }
}
