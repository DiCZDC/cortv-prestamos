<?php

namespace App\Http\Controllers;

class EquipoController extends Controller
{
    public function index()
    {
        return view('vistas.equipo.index');
    }

    public function show($id)
    {
        return view('vistas.equipo.show', ['id' => $id]);
    }

    public function create()
    {
        return view('vistas.equipo.create');

    }
}
