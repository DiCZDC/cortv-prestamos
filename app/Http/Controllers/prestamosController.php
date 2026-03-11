<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class prestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('prestamos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('prestamos.create');
    }

       /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('prestamos.show', ['id' => $id]);
    }

    
}
