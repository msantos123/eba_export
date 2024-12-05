<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Poa;
use App\Models\Estadistica;

class PoaController extends Controller
{
    public function index()//uso
    {
        $poa = Poa::where('meta_estado', 1)
            ->orderBy('created_at', 'desc')
            ->first();
        $estadistica = Estadistica::selectRaw('SUM(volumen_tn) as total, mes')
            ->where('gestion', 2024)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return Inertia::render('Poa/Index',[
            'poa' => $poa,
            'estadistica' => $estadistica,
        ]);
    }

    public function store(Request $request)//uso
    {
        $request->validate([
            'meta_gestion' => 'required|numeric',
            'meta_volumen' => 'required|numeric',
            'meta_monetaria' => 'required|numeric',
        ]);
        $lastActiveRecord = Poa::where('meta_estado', 1)
        ->orderBy('created_at', 'desc')
        ->first();

        if ($lastActiveRecord->meta_gestion == $request->meta_gestion) {
            // Si el año es el mismo, actualizar el registro existente
            $lastActiveRecord->update([
                'meta_volumen' => $request->meta_volumen,
                'meta_monetaria' => $request->meta_monetaria,
            ]);
        } else {
            // Si no existe o el año es diferente, crear un nuevo registro
            Poa::create([
                'meta_gestion' => $request->meta_gestion,
                'meta_volumen' => $request->meta_volumen,
                'meta_monetaria' => $request->meta_monetaria,
                'meta_estado' => 1,
            ]);

            if ($lastActiveRecord) {
                $lastActiveRecord->update([
                    'meta_estado' => 0,
                ]);
            }
        }
        return response()->json(['message' => 'Datos guardados exitosamente.']);
    }

    public function edit()//uso
    {
        $poa =  Poa::where('meta_estado', 1)
                ->orderBy('created_at', 'desc')
                ->first();

        return response()->json($poa);
    }
}
