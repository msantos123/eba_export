<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudcargaRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'planta_id' => ['required'],
            'carga' => ['required', 'array'],
            'carga.*' => ['required', 'array'],
            'carga.*.0' => ['required', 'string'], // codigo_producto
            'carga.*.1' => ['required', 'string'], // nombre_producto
            'carga.*.2' => ['required', 'string'], // Descripción
            'carga.*.4' => ['required', 'numeric'], // Cantidad
            'carga.*.5' => ['required', 'numeric'], // Kilos netos
            'carga.*.6' => ['required', 'numeric'], // Libras netas
        ];
    }
}
