<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargas = Cargas::all();
        return Inertia::render('Cargas/Index',['cargas'=>$cargas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $verCargaDetalle = Carga::select('siga.producto_terminado_movimiento_detalle.*',
        'siga.insumo_receta.rece_nombre as rece_nombre')
        ->join('siga.insumo_receta','siga.insumo_receta.rece_id','=','siga.producto_terminado_movimiento_detalle.mvdpt_rece_id')
        ->where('mvdpt_mvpt_id',$id)
        ->where('mvdpt_estado','A')->get();

        return response()->json($salidaInventarioDetalle);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carga $carga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carga $carga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carga $carga)
    {
        //
    }
}
