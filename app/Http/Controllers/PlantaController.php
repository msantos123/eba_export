<?php

namespace App\Http\Controllers;

use App\Models\Planta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlantaController extends Controller
{
    public function index()
    {
        $planta = Planta::all();
        return Inertia::render('Plantas/Index',['plantas'=>$planta]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|string|max:150|min:10|unique:plantas,nombre',
            'direccion'=>'required|string|max:200',
            'tipo' => 'required',
        ]);
        $planta = new Planta($request->input());
        $planta->save();
        return redirect('plantas');
    }

    public function update(Request $request, Planta $planta)
    {
        $request->validate([
            'nombre'=>'required|string|max:150|min:10',
            'direccion'=>'required|string|max:200',
            'tipo' => 'required',
        ]);
        $planta->update($request->all());
        return redirect('plantas');
    }

    public function destroy(Planta $planta)
    {
        $planta->delete();
        return redirect('plantas');
    }

    public function active($id)
    {
        $planta = Planta::findOrFail($id);

        // Cambia el estado alternadamente
        if ($planta->estado == 0) {
            $planta->estado = 1;
        } else {
            $planta->estado = 0;
        }
        $planta->save();
        return redirect('plantas');
    }
}
