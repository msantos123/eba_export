<?php

namespace App\Http\Controllers;

use App\Models\ComprobanteSalida;
use App\Models\kardex;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComprobanteSalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comprobateSalida = ComprobanteSalida::all();
        return Inertia::render('ComprobanteSalida/Index', [
            'comprobateSalida' => $comprobateSalida,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kardex = kardex::all();
        return Inertia::render('ComprobanteSalida/Create', [
            'kardex' => $kardex,
        ]);
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
    public function show(ComprobanteSalida $comprobanteSalida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComprobanteSalida $comprobanteSalida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComprobanteSalida $comprobanteSalida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComprobanteSalida $comprobanteSalida)
    {
        //
    }
}
