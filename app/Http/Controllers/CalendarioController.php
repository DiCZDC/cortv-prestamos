<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('vistas.calendario.index');
    }
    public function show($id)
    {
        return view('vistas.calendario.show', ['id' => $id]);
    }
}
