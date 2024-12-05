<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
//models
use App\Models\Inventario;

class InventarioController extends Controller
{
    public function index ()
    {
        $inventario = Inventario::indexInventario();

        return Inertia::render('ProductoTerminado/Index',[
            'inventario'=>$inventario
        ]);
    }

    public function show ($producto,$planta)
    {
        $showInventario = Inventario::showInventario($producto,$planta);
        return response()->json($showInventario);
    }
}
