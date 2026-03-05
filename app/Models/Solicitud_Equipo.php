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

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
