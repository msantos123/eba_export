<script setup>
import {useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextDisabled from '@/Components/TextDisabled.vue';

const props = defineProps({
    kardex: { type: Object },
    detallekardex: { type: Object},
})

const form = useForm({
    //kardex
    id:props.kardex.id,
    codigo_producto:props.kardex.codigo_producto,
    articulo:props.kardex.articulo,
    proveedor:props.kardex.plantas_nombre,
    ubicacion:props.kardex.ubicacion,
    unidad:props.kardex.unidad,
    lote:props.kardex.lote,
    saldo:props.kardex.saldo,
    //detallekardex
    kardex_id:props.detallekardex.kardex_id,
    tipo_movimiento:props.detallekardex.tipo_movimiento,
    empresa:props.detallekardex.empresa,
    codigo_conocimiento:props.detallekardex.codigo_conocimiento,
    ingreso_id:props.detallekardex.codigoIngreso,
    salida_id:props.detallekardex.salida_id,
    ingreso:props.detallekardex.ingreso,
    salida:props.detallekardex.saldo,
    fecha_ingreso:props.detallekardex.fechaIngreso,
});
</script>

<template>
    <InputLabel value="Datos Kardex" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
        <div class="grid grid-cols-3 gap-4 mt-4">
            <div>
                <InputLabel for="codigo_producto" value="Codigo de Producto"></InputLabel>
                <TextDisabled id="codigo_producto" type="text" class="mt-2 block w-full"
                v-model="form.codigo_producto" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="articulo" value="Articulo"></InputLabel>
                <TextDisabled id="articulo" type="text" class="mt-2 block w-full"
                v-model="form.articulo" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="proveedor" value="Proveedor"></InputLabel>
                <TextDisabled id="proveedor" type="text" class="mt-2 block w-full"
                v-model="form.proveedor" disabled></TextDisabled>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4">
            <div>
                <InputLabel for="ubicacion" value="Ubicacion"></InputLabel>
                <TextDisabled id="ubicacion" type="text" class="mt-2 block w-full"
                v-model="form.ubicacion" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="unidad" value="Unidad"></InputLabel>
                <TextDisabled id="unidad" type="text" class="mt-2 block w-full"
                v-model="form.unidad" disabled></TextDisabled>
            </div>
            <div>
                <InputLabel for="lote" value="Nro.Lote"></InputLabel>
                <TextDisabled id="lote" type="text" class="mt-2 block w-full"
                v-model="form.lote" disabled></TextDisabled>
            </div>
        </div>
</template>
