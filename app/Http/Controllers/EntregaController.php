<?php

namespace App\Http\Controllers;
use App\Models\Solicitud;
use Carbon\Carbon;

class EntregaController extends Controller
{
    public function index()
    {
        return view('vistas.entrega.index');
    }

    public function show($id)
    {
        $prestamo = Solicitud::find($id);

        $fecha_entrega = Carbon::parse($prestamo->fecha_prestamo)->startOfDay();
        $fecha_hoy = Carbon::now()->startOfDay();
        $color_text = '';
        $icono ='';

        $diferencia_dias = $fecha_entrega->diffInDays($fecha_hoy, false);

        if ($diferencia_dias < 0) {
            $fecha= (int) (abs($diferencia_dias));
        
            $titulo = $fecha . ' días restantes';
            $descripcion = 'Para el dia de entrega';
            $icono = 'clock-check';
        } 
        elseif ($diferencia_dias > 0) {
            $fecha= (int) $diferencia_dias ;
            
            $titulo = $fecha . ' días de atraso';
            $descripcion = 'Desde el dia de entrega';
            $color_text = 'text-rojo_claro';
            $icono = 'clock-alert';
        } 
        else {
            $titulo = 'Hoy es el día de entrega';
            $descripcion = '';
            $icono = 'clock-check'; 
        }

        return view('vistas.entrega.show', compact('prestamo', 'id', 'titulo', 'descripcion', 'color_text', 'icono'));
    }
}
