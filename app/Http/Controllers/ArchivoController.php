<?php

namespace App\Http\Controllers;

class ArchivoController extends Controller
{
    public function index()
    {
        return view('vistas.archivo.index');
    }

    public function show($id)
    {
        return view('vistas.archivo.show', ['id' => $id]);
    }
}
