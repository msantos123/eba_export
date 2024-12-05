<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ctrt_fecha_contrato' => 'required|date',
            'ctrt_vendedor' => 'required|string|max:255',
            'ctrt_comprador' => 'required|string|max:255',
            'ctrt_direccion_comprador' => 'required|string|max:255',
            'ctrt_producto' => 'required|string|max:255',
            'ctrt_precio' => 'required|numeric|min:1',
            'ctrt_precio_html' => 'string',
            'ctrt_medida' => 'required|string|in:Tn,lb,kg,g',
            'ctrt_terminos_envio' => 'required|string',
            'ctrt_embarque' => 'required|string',
            'ctrt_empaque' => 'required|string',
            'selectedAnalisis' => 'nullable|array',
            'ctrt_cantidad' => 'required|numeric|min:1',
            'ctrt_por_anticipo' => 'required|numeric|min:1|max:100',
            'ctrt_pago' => 'required|string',
            'ctrt_pago_html' => 'required|string',
            'ctrt_por_pago' => 'required|numeric|min:1|max:100',
            'ctrt_terminos' => 'required|string',
            'ctrt_doc_vendedor' => 'required|string|max:255',
            'ctrt_doc_comprador' => 'required|string|max:255',
            'ctrt_adicional_etiqueta' => 'nullable|max:255',
            'ctrt_adicional_contenido' => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [

            'ctrt_fecha_contrato.required' => 'La fecha del contrato es obligatoria.',
            'ctrt_fecha_contrato.date' => 'La fecha del contrato debe ser una fecha válida.',

            'ctrt_vendedor.required' => 'El vendedor es obligatorio.',
            'ctrt_vendedor.string' => 'El vendedor debe ser una cadena de texto.',
            'ctrt_vendedor.max' => 'El vendedor no puede exceder los 255 caracteres.',

            'ctrt_comprador.required' => 'El comprador es obligatorio.',
            'ctrt_comprador.string' => 'El comprador debe ser una cadena de texto.',
            'ctrt_comprador.max' => 'El comprador no puede exceder los 255 caracteres.',

            'ctrt_direccion_comprador.required' => 'La direccion del comprador es obligatorio.',
            'ctrt_direccion_comprador.string' => 'La direccion del comprador debe ser una cadena de texto.',
            'ctrt_direccion_comprador.max' => 'La direccion del comprador no puede exceder los 255 caracteres.',

            'ctrt_producto.required' => 'El producto es obligatorio.',
            'ctrt_producto.string' => 'El producto debe ser una cadena de texto.',
            'ctrt_producto.max' => 'El producto no puede exceder los 255 caracteres.',

            'ctrt_precio.required' => 'El precio es obligatorio.',
            'ctrt_precio.numeric' => 'El precio debe ser un número.',
            'ctrt_precio.min' => 'El precio debe ser al menos 0.',

            'ctrt_medida.required' => 'La medida es obligatoria.',
            'ctrt_medida.in' => 'Debe selecionar una unidad de medida',

            'ctrt_terminos_envio.required' => 'Los términos son obligatorios.',
            'ctrt_terminos_envio.string' => 'Los términos deben ser una cadena de texto.',

            'ctrt_terminos.required' => 'Los términos son obligatorios.',
            'ctrt_terminos.string' => 'Los términos deben ser una cadena de texto.',

            'ctrt_embarque.required' => 'El embarque es obligatorio.',
            'ctrt_embarque.string' => 'El embarque debe ser una cadena de texto.',

            'ctrt_empaque.required' => 'El empaque es obligatorio.',
            'ctrt_empaque.string' => 'El empaque debe ser una cadena de texto.',

            'ctrt_cantidad.required' => 'La cantidad es obligatoria.',
            'ctrt_cantidad.numeric' => 'La cantidad debe ser un número.',
            'ctrt_cantidad.min' => 'La cantidad debe ser al menos 1.',

            'ctrt_por_anticipo.required' => 'El porcentaje de anticipo es obligatorio.',
            'ctrt_por_anticipo.numeric' => 'El porcentaje de anticipo debe ser un número.',
            'ctrt_por_anticipo.min' => 'El porcentaje de anticipo debe ser al menos 1.',
            'ctrt_por_anticipo.max' => 'El porcentaje de anticipo no puede exceder 100.',

            'ctrt_pago.required' => 'El porcentaje de pago es obligatorio.',
            'ctrt_pago.string' => 'El porcentaje de pago debe ser un número.',

            'ctrt_doc_vendedor.required' => 'El documento de vendedor es obligatorio',
            'ctrt_doc_vendedor.string' => 'El documento del vendedor debe ser una cadena de texto.',
            'ctrt_doc_vendedor.max' => 'El documento del vendedor no puede exceder los 255 caracteres.',

            'ctrt_doc_comprador.required' => 'El documento de comprador es obligatorio',
            'ctrt_doc_comprador.string' => 'El documento del comprador debe ser una cadena de texto.',
            'ctrt_doc_comprador.max' => 'El documento del comprador no puede exceder los 255 caracteres.',

            'ctrt_adicional_etiqueta.string' => 'El "Titulo de Campo Adiconal" deben ser una cadena de texto.',
            'ctrt_adicional_contenido.string' => 'El "Contenido de Campo Adicional" deben ser una cadena de texto.',
        ];
    }
}
