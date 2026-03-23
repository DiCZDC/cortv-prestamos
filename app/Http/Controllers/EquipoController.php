<?php

namespace App\Http\Controllers;
use App\Charts\Prueba;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index(Prueba $chart)
    {
        return view('equipo.index', ['chart' => $chart->build()]);
    }

    public function show($id)
    {
        // Aquí puedes agregar la lógica para mostrar los detalles de un préstamo específico
        return view('equipo.show', ['id' => $id]);
    }
}
