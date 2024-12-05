<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LiberacionRequest extends FormRequest
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
            'documentos.*' => 'required|mimes:pdf',
            'nros.*' => 'required|string',
            'factura' => 'required|string',
            'libe_nave_viaje' => 'required|string',
            'libe_bl' => 'required|string',
            'libe_puerto' => 'required|string',
            'libe_consignatario' => 'required|string',
            'libe_direccion' =>  'required|string',
        ];
    }

    public function messages()
    {
        return [
            //'documentos.*.required' => 'El documento es obligatorio.',
            //'documentos.*.mimes' => 'El documento debe ser un archivo PDF.',
            'nros.*.required' => 'El número es obligatorio.',
            'nros.*.string' => 'El número debe ser una cadena de texto.',
            'factura.required' => 'El campo factura es obligatorio.',
            'factura.string' => 'El campo factura debe ser una cadena de texto.',
            'libe_nave_viaje.required' => 'El campo Nave/Viaje es obligatorio.',
            'libe_nave_viaje.string' => 'El campo Nave/Viaje debe ser una cadena de texto.',
            'libe_bl.required' => 'El campo de Bill of Lading es obligatorio.',
            'libe_bl.string' => 'El campo de Bill of Lading debe ser una cadena de texto.',
            'libe_puerto.required' => 'El campo de Puerto de descarga es obligatorio.',
            'libe_puerto.string' => 'El campo de Puerto de descarga debe ser una cadena de texto.',
            'libe_consignatario.required' => 'El campo nombre de consignatario es obligatorio.',
            'libe_consignatario.string' => 'El campo nombre de consignatario debe ser una cadena de texto.',
            'libe_direccion.required' => 'El campo dirección de consignatario es obligatorio.',
            'libe_direccion.string' => 'El campo dirección de consignatario debe ser una cadena de texto.',
        ];
    }
}
