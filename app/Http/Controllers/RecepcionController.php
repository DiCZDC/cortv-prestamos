<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Solicitud;

class RecepcionController extends Controller
{
    public function index()
    {
        return view('vistas.recepcion.index');
    }

    public function show($id)
    {
        // Aquí puedes agregar la lógica para mostrar los detalles de un préstamo específico
        $prestamo = Solicitud::find($id);
        
        $fecha_devolucion = Carbon::parse($prestamo->fecha_devolucion);
        $fecha_hoy = Carbon::now();
        $color_text = '';

        $diferencia_dias = $fecha_devolucion->diffInDays($fecha_hoy, false);
        
        if ($diferencia_dias < 0) {
            $fecha= (int) (abs($diferencia_dias)) + 1;
        
            $titulo = $fecha . ' días restantes';
            $descripcion = 'Para el dia de entrega';
        } 
        elseif ($diferencia_dias > 0) {
            $fecha= (int) (abs($diferencia_dias)) ;
            
            $titulo = $fecha . ' días de retraso';
            $descripcion = 'Desde el dia de entrega';
            $color_text = 'text-rojo_claro';
        } 
        else {
            $titulo = 'Hoy es el día de entrega';
            $descripcion = 'Entrega programada para hoy';
        }



        return view('vistas.recepcion.show', ['id' => $id,  'prestamo' => $prestamo, 'titulo' => $titulo, 'descripcion' => $descripcion, 'color_text' => $color_text]);
    }
}
