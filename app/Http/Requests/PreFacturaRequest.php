<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreFacturaRequest extends FormRequest
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
            'comprobante_salida' => 'required',
            'mes' => 'required|string',
            'fecha_factura' => 'required|date',
            'nro_factura' => 'required|integer',
            'razon_social' => 'required|string|max:255',
            'nit' => 'nullable|string|max:255',
            'incoterm' => 'required|string|max:255',
            'lugar_destino' => 'required|string|max:255',
            'puerto_destino' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'tipo_cambio' => 'required',
            'zafra' => 'required|integer',
            'total_facturado_usd' => 'required|numeric',
            'total_facturado_bs' => 'required|numeric',
            'comision' => 'nullable|numeric',
            'total_pagar_usd' => 'required|numeric',
            'total_pagar_bs' => 'required|numeric',
            'primer_pago' => 'nullable|numeric',
            'fecha_primer_pago' => 'nullable|date',
            'segundo_pago' => 'nullable|numeric',
            'fecha_segundo_pago' => 'nullable|date',
            'tercer_pago' => 'nullable|numeric',
            'fecha_tercer_pago' => 'nullable|date',
            'total_pagos' => 'nullable|numeric',
            'saldos' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'mes.required' => 'El campo mes es obligatorio.',
            'mes.string' => 'El mes debe ser una cadena de texto.',
            'mes.max' => 'El mes no puede tener más de 255 caracteres.',
            'fecha_factura.required' => 'La fecha de la factura es obligatoria.',
            'fecha_factura.date' => 'La fecha de la factura debe ser una fecha válida.',
            'nro_factura.required' => 'El número de factura es obligatorio.',
            'nro_factura.integer' => 'El número de factura debe ser un número entero.',
            'razon_social.required' => 'La razón social es obligatoria.',
            'razon_social.string' => 'La razón social debe ser una cadena de texto.',
            'razon_social.max' => 'La razón social no puede tener más de 255 caracteres.',
            'nit.max' => 'El NIT no puede tener más de 255 caracteres.',
            'incoterm.required' => 'El campo incoterm es obligatorio.',
            'incoterm.string' => 'El incoterm debe ser una cadena de texto.',
            'incoterm.max' => 'El incoterm no puede tener más de 255 caracteres.',
            'lugar_destino.required' => 'El lugar de destino es obligatorio.',
            'lugar_destino.string' => 'El lugar de destino debe ser una cadena de texto.',
            'lugar_destino.max' => 'El lugar de destino no puede tener más de 255 caracteres.',
            'puerto_destino.required' => 'El puerto de destino es obligatorio.',
            'puerto_destino.string' => 'El puerto de destino debe ser una cadena de texto.',
            'puerto_destino.max' => 'El puerto de destino no puede tener más de 255 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
            'tipo_cambio.required' => 'El tipo de cambio es obligatorio.',
            'tipo_cambio.numeric' => 'El tipo de cambio debe ser un número.',
            'zafra.required' => 'El campo zafra es obligatorio.',
            'zafra.integer' => 'La zafra debe ser un número entero.',
            'total_facturado_usd.required' => 'El total facturado en USD es obligatorio.',
            'total_facturado_usd.numeric' => 'El total facturado en USD debe ser un número.',
            'total_facturado_bs.required' => 'El total facturado en BS es obligatorio.',
            'total_facturado_bs.numeric' => 'El total facturado en BS debe ser un número.',
            'comision.numeric' => 'La comisión debe ser un número.',
            'total_pagar_usd.required' => 'El total a pagar en USD es obligatorio.',
            'total_pagar_usd.numeric' => 'El total a pagar en USD debe ser un número.',
            'total_pagar_bs.required' => 'El total a pagar en BS es obligatorio.',
            'total_pagar_bs.numeric' => 'El total a pagar en BS debe ser un número.',
            'primer_pago.numeric' => 'El primer pago debe ser un número.',
            'fecha_primer_pago.date' => 'La fecha del primer pago debe ser una fecha válida.',
            'segundo_pago.numeric' => 'El segundo pago debe ser un número.',
            'fecha_segundo_pago.date' => 'La fecha del segundo pago debe ser una fecha válida.',
            'tercer_pago.numeric' => 'El tercer pago debe ser un número.',
            'fecha_tercer_pago.date' => 'La fecha del tercer pago debe ser una fecha válida.',
            'total_pagos.numeric' => 'El total de pagos debe ser un número.',
            'saldos.numeric' => 'El saldo debe ser un número.',
        ];
    }

}
