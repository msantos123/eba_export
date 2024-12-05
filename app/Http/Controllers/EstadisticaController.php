<?php

namespace App\Http\Controllers;

use App\Imports\EstadisticasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Inertia\Inertia;
use App\Models\Estadistica;
use App\Models\PreFactura;


class EstadisticaController extends Controller
{
    public function index()//uso
    {
        $datos = Estadistica::count() > 0;
        $fechaDatos = $datos ? Estadistica::latest()->first()->created_at : null;
        return Inertia::render('Estadistica/Index',[
            'datos' => $datos,
            'fechaDatos' => $fechaDatos,
        ]);
    }

    public function update_excel(Request $request)//uso
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Estadistica::truncate();
        Excel::import(new EstadisticasImport, $request->file('file'));
        return response()->json(['message' => 'Excel importado con Existo']);
    }

    public function sumatoria(Request $request)//uso
    {
        $category = $request->input('categories');
        $field = $request->input('field');
        $operacion = $request->input('operacion');

        if (empty($category) || !is_string($category)) {
            return response()->json(['error' => 'Category must be a non-empty string'], 400);
        }

        $selectField = "$category as etiqueta";
        $operation = "$operacion($field) as total";

        $result = PreFactura::select($selectField)
        ->selectRaw( $operation)
        ->groupBy($category)
        ->get();
        return response()->json($result);
    }
}
