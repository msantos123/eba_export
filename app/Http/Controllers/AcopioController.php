<?php

namespace App\Http\Controllers;
use App\Models\Kardex;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AcopioController extends Controller
{
    public function index()//uso
    {
        $kardexRiberalta = Kardex::where('proveedor_id', 9)
        ->whereNotNull('costo_caja')->get();
        $kardexSena = Kardex::where('proveedor_id', 10)
        ->whereNotNull('costo_caja')->get();
        $kardexCobija = Kardex::where('proveedor_id', 25)
        ->whereNotNull('costo_caja')->get();
        return Inertia::render('Acopio/Index',[
            'kardexRiberalta'=>$kardexRiberalta,
            'kardexSena'=>$kardexSena,
            'kardexCobija'=>$kardexCobija,
        ]);
    }
}
