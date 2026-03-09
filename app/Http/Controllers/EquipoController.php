<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        return view('equipo.index');
    }

    public function show($id)
    {
        // Aquí puedes agregar la lógica para mostrar los detalles de un préstamo específico
        return view('equipo.show', ['id' => $id]);
    }
}
