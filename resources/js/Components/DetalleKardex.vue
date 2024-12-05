<script>
    export default {
        name: 'DetalleKardex'
    }
</script>
<script setup>
import {defineProps} from 'vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    kardex: { type: Object },
    detallekardex: { type: Object },
})

const form = useForm({
    //kardex
    codigo_producto:props.kardex.codigo_producto,
    articulo:props.kardex.articulo,
    proveedor:props.kardex.proveedor,
    ubicacion:props.kardex.ubicacion,
    unidad:props.kardex.unidad,
    lote:props.kardex.lote,
    saldo:props.kardex.saldo,
    //detallekardex
    kardex_id:props.detallekardex.kardex_id,
    fecha_produccion:props.fecha_produccion,
    tipo_movimiento:props.detallekardex.tipo_movimiento,
    empresa:props.detallekardex.empresa,
    codigo_conocimiento:props.detallekardex.codigo_conocimiento,
    ingreso_id:props.detallekardex.codigoIngreso,
    salida_id:props.detallekardex.codigoSalida,
    ingreso:props.detallekardex.ingreso,
    salida:props.detallekardex.saldo,
    fecha_ingreso:props.detallekardex.fechaIngreso,
    fecha_salida:props.detallekardex.fechaSalida,
});

const totalIngreso = computed(() => {
  return props.detallekardex.reduce((acc, item) => acc + (item.ingreso || 0), 0)
})

const totalSalida = computed(() => {
  return props.detallekardex.reduce((acc, item) => acc + (item.salida || 0), 0)
})

</script>
<template>
    <InputLabel value="Detalle" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
    <br>
    <table class="w-full border-collapse font-semibold uppercase">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Fecha Ingreso</th>
                <th class="px-4 py-2">Fecha Salida</th>
                <th class="px-4 py-2">Tipo Movimiento</th>
                <th class="px-4 py-2">Empresa</th>
                <th class="px-4 py-2">Conocimiento</th>
                <th class="px-4 py-2">Comprobante Ingreso</th>
                <th class="px-4 py-2">Comprobante Salida</th>
                <th class="px-4 py-2">Ingreso</th>
                <th class="px-4 py-2">Salida</th>
                <th class="px-4 py-2">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="det, i in detallekardex" :key="det.id" class="border-b">
                <td class="px-4 py-2">{{ det.fechaIngreso }}</td>
                <td class="px-4 py-2">{{ det.fechaSalida }}</td>
                <td class="px-4 py-2">{{ det.tipo_movimiento }}</td>
                <td class="px-4 py-2">{{ det.empresa }}</td>
                <td class="px-4 py-2">{{ det.codigo_conocimiento }}</td>
                <td class="px-4 py-2">{{ det.codigoIngreso }}</td>
                <td class="px-4 py-2">{{ det.codigoSalida }}  </td>
                <td class="px-4 py-2">{{ det.ingreso }}</td>
                <td class="px-4 py-2">{{ det.salida }}</td>
                <td class="px-4 py-2"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-gray-200">
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2">Totales</th>
                <th class="px-4 py-2">{{ totalIngreso }}</th>
                <th class="px-4 py-2">{{ totalSalida }}</th>
                <th class="px-4 py-2">{{ props.kardex.saldo }}</th>
            </tr>
        </tfoot>
    </table>
</template>


