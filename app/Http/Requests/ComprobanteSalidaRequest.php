<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComprobanteSalidaRequest extends FormRequest
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
            'fecha_salida' => 'required|date',
            'empresa' => 'required|string|max:100',
            'responsable' => 'required|string|max:100',
            'camion' => 'required|string|max:50',
            'placa' => 'required|string|max:10',
            'licencia' => 'required|string|max:10',
            'celular' => 'required|integer',
            'contenedor' => 'required|string|max:20',
            'presinto' => 'required|string|max:20',
            'reserva' => 'required|string|max:20',
            'factura' => 'required|integer',
            'destino' => 'required|string|max:100',
            'codigo_salida' => 'required|string|max:20',
            'pdf_comprobante_salida' => 'nullable|string|max:100',
            'liberacion' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'fecha_salida.required' => 'La fecha de salida es obligatoria.',
            'empresa.required' => 'La empresa es obligatoria.',
            'empresa.max' => 'La empresa no puede exceder los 100 caracteres.',
            'responsable.required' => 'El responsable es obligatorio.',
            'responsable.max' => 'El responsable no puede exceder los 100 caracteres.',
            'camion.required' => 'El campo camion es obligatorio.',
            'camion.max' => 'El camion no puede exceder los 50 caracteres.',
            'placa.required' => 'La placa es obligatoria.',
            'placa.max' => 'La placa no puede exceder los 10 caracteres.',
            'licencia.required' => 'La licencia es obligatoria.',
            'licencia.max' => 'La licencia no puede exceder los 10 caracteres.',
            'celular.required' => 'El celular es obligatorio.',
            'contenedor.required' => 'El contenedor es obligatorio.',
            'contenedor.max' => 'El contenedor no puede exceder los 20 caracteres.',
            'presinto.required' => 'El presinto es obligatorio.',
            'presinto.max' => 'El presinto no puede exceder los 20 caracteres.',
            'reserva.required' => 'La reserva es obligatoria.',
            'reserva.max' => 'La reserva no puede exceder los 20 caracteres.',
            'factura.required' => 'La factura es obligatoria.',
            'destino.required' => 'El destino es obligatorio.',
            'destino.max' => 'El destino no puede exceder los 100 caracteres.',
            'codigo_salida.required' => 'El código de salida es obligatorio.',
            'codigo_salida.max' => 'El código de salida no puede exceder los 20 caracteres.',
            'pdf_comprobante_salida.max' => 'El archivo PDF no puede exceder los 100 caracteres.',
            'liberacion.integer' => 'La liberación debe ser un número entero.',
        ];
    }
}
