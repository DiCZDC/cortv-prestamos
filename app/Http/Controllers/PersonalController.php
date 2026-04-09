<?php

namespace App\Http\Controllers;

class PersonalController extends Controller
{
    public function index()
    {
        return view('vistas.personal.index');
    }

    public function show($id)
    {
        // Aquí puedes agregar la lógica para mostrar los detalles de un préstamo específico
        return view('vistas.personal.show', ['id' => $id]);
    }
}
