<?php

namespace App\Http\Controllers;
use App\Models\Costo;
use App\Models\Planta;
use App\Models\Kardex;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostoController extends Controller
{
    public function index ()//uso
    {
        $kardex = Kardex::all();
        return Inertia::render('Costos/Index', [
            'kardex' => $kardex,
        ]);
    }

    public function update_costo(Request $request)//uso
    {
        $request->validate([
            'id' => 'required|numeric',
            'costo_caja' => 'required|numeric',
        ]);

        $costo = Kardex::find($request->id);
        $costo->costo_caja = $request->costo_caja;
        $costo->save();

        return response()->json(['message' => 'Datos guardados exitosamente.']);
    }
}
