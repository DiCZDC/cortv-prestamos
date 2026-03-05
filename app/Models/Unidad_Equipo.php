<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad_Equipo extends Model
{
    /** @use HasFactory<\Database\Factories\UnidadEquipoFactory> */
    use HasFactory;
    
    protected $fillable = [
        'equipo_id',
        'numero_serie',
        'estado',
    ];
    
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
    
}
