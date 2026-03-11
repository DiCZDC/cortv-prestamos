<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecepcionController extends Controller
{
    public function index()
    {
        return view('recepcion.index');
    }

    public function show($id)
    {
        // Aquí puedes agregar la lógica para mostrar los detalles de un préstamo específico
        return view('recepcion.show', ['id' => $id]);
    }
}
