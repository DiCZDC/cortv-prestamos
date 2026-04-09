<?php

namespace App\Http\Controllers;

class EquipoController extends Controller
{
    public function index()
    {
        return view('equipo.index');
    }

    public function show($id)
    {
        return view('equipo.show', ['id' => $id]);
    }
    public function create()
    {
        return view('equipo.create');

    }
}
