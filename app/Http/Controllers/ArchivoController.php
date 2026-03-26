<?php

namespace App\Http\Controllers;

class ArchivoController extends Controller
{
    public function index()
    {
        return view('archivo.index');
    }

    public function show($id)
    {
        return view('archivo.show', ['id' => $id]);
    }
}
