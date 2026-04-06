<?php

namespace App\Models;

use Database\Factories\SolicitudFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    /** @use HasFactory<SolicitudFactory> */
    use HasFactory;

    protected $fillable = [
        'id_trabajador',
        'id_admin',
        'motivo',
        'estado',
        'fecha_prestamo',
        'fecha_devolucion',
        'fecha_entrega',
    ];

    
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function unidad_equipos()
    {
        return $this->BelongsToMany(Unidad_Equipo::class);
    }
}
