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

        $user = User::find($request->trabajador);

        DB::transaction(function () use ($validated) {
            $solicitud = Solicitud::create([
                'id_trabajador' => $validated['trabajador'],
                'id_admin' => $validated['estado'] === 'Autorizada' ? Auth::user()->id : null,
                'motivo' => $validated['motivo'],
                'estado' => $validated['estado'],
                'fecha_prestamo' => $validated['fecha_prestamo'],
                'fecha_devolucion' => $validated['fecha_devolucion'],
            ]);

            foreach ($validated['equipos_seleccionados'] as $unidad_id) {
                $unidad = Unidad_Equipo::lockForUpdate()->find($unidad_id);

                Solicitud_Equipo::create([
                    'id_solicitud' => $solicitud->id,
                    'id_unidad_equipo' => $unidad_id,
                ]);
            }
        }, attempts: 3);
        $header = "Tu solicitud de préstamo ha sido {$validated['estado']}";
        $subtitle = "Motivo: {$validated['motivo']}";
        Notification::send($user, new solicitud_notification($header, $subtitle));
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
