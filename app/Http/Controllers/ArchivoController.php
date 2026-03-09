<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
