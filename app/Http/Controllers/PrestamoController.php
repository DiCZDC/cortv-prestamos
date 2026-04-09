<?php

namespace App\Http\Controllers;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vistas.prestamo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vistas.prestamo.create');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('vistas.prestamo.show', ['id' => $id]);
    }
}
