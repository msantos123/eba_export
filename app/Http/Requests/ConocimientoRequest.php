<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConocimientoRequest extends FormRequest
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
            'empresa'       => 'required|string|max:80|min:10',
            'conductor'     => 'required|string|max:50|min:10',
            'vehiculo'      => 'required|string|max:50|min:10',
            'propietario'   => 'required|string|max:50|min:10',
            'licencia'      => 'required|string|max:15|min:5',
            'placa'         => 'required|string|max:10|min:7',
            'celular'       => 'required|numeric|digits:8',
        ];
    }

    public function messages()
    {
        return [
            'empresa.required' => 'La empresa transportista es obligatorio.',
            'empresa.max'      => 'La empresa transportista no puede tener más de 80 caracteres',
            'empresa.min'      => 'La empresa transportista debe tener al menos 20 caracteres',
            'conductor.required' => 'El conductor es obligatorio.',
            'conductor.max'      => 'El conductor no puede tener más de 50 caracteres',
            'conductor.min'      => 'El conductor debe tener al menos 10 caracteres',
            'vehiculo.required' => 'El vehiculo es obligatorio.',
            'vehiculo.max'      => 'El vehiculo no puede tener más de 50 caracteres',
            'vehiculo.min'      => 'El vehiculo debe tener al menos 10 caracteres',
            'propietario.required' => 'El propietario es obligatorio.',
            'propietario.max'      => 'El propietario no puede tener más de 50 caracteres.',
            'propietario.min'      => 'El propietario debe tener al menos 10 caracteres.',
            'licencia.required' => 'La licencia es obligatorio.',
            'licencia.max'      => 'La licencia no puede tener más de 15 caracteres.',
            'licencia.min'      => 'La licencia debe tener al menos 5 caracteres.',
            'placa.required' => 'La placa es obligatorio.',
            'placa.max'      => 'La placa no puede tener más de 10 caracteres.',
            'placa.min'      => 'La placa debe tener al menos 7 caracteres.',
            'celular.required' => 'El celular es obligatorio.',
            'celular.numeric' => 'El celular debe ser un número.',
            'celular.digits' => 'El celular debe tener 8 dígitos.',

        ];
    }
}
