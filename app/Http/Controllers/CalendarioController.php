<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('calendario.index');
    }
    public function show($id)
    {
        return view('calendario.show', ['id' => $id]);
    }
}
