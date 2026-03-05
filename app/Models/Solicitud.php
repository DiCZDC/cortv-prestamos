<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    /** @use HasFactory<\Database\Factories\SolicitudFactory> */
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'fecha_solicitud',
        'estado',
    ];

    public function solicitud_equipos()
    {
        return $this->hasMany(Solicitud_Equipo::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    public function unidad_equipos()
    {
        return $this->hasManyThrough(Unidad_Equipo::class);
    }
}
