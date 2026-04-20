<?php

namespace App\Http\Controllers;

class EntregaController extends Controller
{
    public function index()
    {
        return view('vistas.entrega.index');
    }

    public function show($id)
    {
        return view('vistas.entrega.show', compact('id'));
    }
}
