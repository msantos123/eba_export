<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComprobanteIngresoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'fecha_ingreso' => 'required|date', // Asegúrate de que sea una fecha válida
            'codigo_ingreso' => 'required|string|max:255', // Ajusta max según tus necesidades
            'cefo' => 'required|string|max:255', // Ajusta max según tus necesidades
            'observaciones' => 'nullable|string|max:500', // Opcional, con un límite de caracteres
        ];
    }

    public function messages()
    {
        return [
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida. Ej. 2024-11-27',
            'codigo_ingreso.required' => 'El código de ingreso es obligatorio.',
            'cefo.required' => 'El número CEFO es obligatorio.',
            'cefo.string' => 'El CEFO debe ser un texto',
            'observaciones.max' => 'Las observaciones no pueden exceder los 500 caracteres.',
        ];
    }
}
