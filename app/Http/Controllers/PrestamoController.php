<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Notifications\solicitud_notification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class PrestamoController extends Controller
{
    /**
     * Crear una solicitud de préstamo autorizada (para admins)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'motivo' => ['required', 'min:10', 'max:255'],
            'fecha_prestamo' => ['required', 'date'],
            'fecha_devolucion' => ['required', 'date'],
            'equipos_seleccionados' => ['required', 'array', 'min:1'],
            'trabajador' => ['required', 'exists:users,id'],
            'estado' => ['required', 'in:Pendiente,Autorizada,Rechazada,Entregada,Devuelta'],
        ]);

        
            $solicitud = DB::transaction(function () use ($validated) {
                $solicitud = Solicitud::create([
                'id_trabajador' => $validated['trabajador'],
                'id_admin' => $validated['estado'] === 'Autorizada' ? Auth::user()->id : null,
                'motivo' => $validated['motivo'],
                'estado' => $validated['estado'],
                'fecha_prestamo' => $validated['fecha_prestamo'],
                'fecha_devolucion' => $validated['fecha_devolucion'],
                ]);

                foreach ($validated['equipos_seleccionados'] as $unidad_id) {
                $unidad = Unidad_Equipo::lockForUpdate()->findOrFail($unidad_id);

                Solicitud_Equipo::create([
                    'id_solicitud' => $solicitud->id,
                    'id_unidad_equipo' => $unidad->id,
                ]);
                }

                return $solicitud;
            }, attempts: 3);


        if(Auth::user()->hasRole('admin')) {
            Notification::send(
                User::find($validated['trabajador']), 
                new solicitud_notification(
                    "Tu solicitud de préstamo ha sido creada y autorizada por: ".Auth::user()->name,
                    "Motivo: {$validated['motivo']}",
                    "archivo/{$solicitud->id}"
            ));


        }elseif(Auth::user()->hasRole('trabajador')) {
            $trabajador = User::find($validated['trabajador']);
            Notification::send(
                User::role('admin')->get(), 
                new solicitud_notification(
                    "{$trabajador->name} ha enviado una solicitud de préstamo",
                    "Motivo: {$validated['motivo']}",
                    "prestamo/{$solicitud->id}"
            ));
        }
    }

    public function update(Request $request){
        $validated = $request->validate([
            'solicitud_id' => ['required', 'exists:solicituds,id'],
            'estado' => ['required', 'in:Pendiente,Autorizada,Rechazada,Entregada,Devuelta'],
            'id_admin' => ['required', 'exists:users,id'],
        ]);

        $estado = $validated['estado'];
        Solicitud::where('id', $validated['solicitud_id'])->update([
            'estado' => $estado,
            'id_admin' => $validated['id_admin'],
        ]);

        Notification::send(
            Solicitud::find($validated['solicitud_id'])->trabajador, 
            new solicitud_notification(
                "Tu solicitud de préstamo ha sido {$estado} por ".Auth::user()->name,
                "Motivo: ".Solicitud::find($validated['solicitud_id'])->motivo,
                "archivo/{$validated['solicitud_id']}"
        ));

        if (!in_array($estado, ['Autorizada', 'Rechazada'])) {
            return response()->json(['error' => 'Estado no válido para esta acción.'], 400);
        }
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vistas.prestamo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vistas.prestamo.create');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('vistas.prestamo.show', ['id' => $id]);
    }
}
