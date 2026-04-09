<?php

namespace App\Http\Controllers;

class RecepcionController extends Controller
{
    public function index()
    {
        return view('vistas.recepcion.index');
    }

    public function show($id)
    {
        // Aquí puedes agregar la lógica para mostrar los detalles de un préstamo específico
        return view('vistas.recepcion.show', ['id' => $id]);
    }
}
