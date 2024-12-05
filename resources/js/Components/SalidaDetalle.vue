<script>
export default {
    name: 'SalidaDetalle'
}
</script>
<script setup>
import {defineProps, defineEmits, ref} from 'vue';
import { computed } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    salidaDetalle: {
        type: Object,
    },
})

</script>
<template>
    <InputLabel value="Detalle de Salida Inventario Almacen" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
    <br>
    <table class="w-full border-collapse font-semibold uppercase">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Codigo</th>
                <th class="px-4 py-2">Producto</th>
                <th class="px-4 py-2">Lote</th>
                <th class="px-4 py-2">Cantidad</th>
                <th class="px-4 py-2">Fecha Elaboracion</th>
                <th class="px-4 py-2">Fecha Vencimiento</th>
                <th class="px-4 py-2">Fecha Envasado</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="sal, i in salidaDetalle" :key="sal.id">
                <td class="px-4 py-2"> {{ sal.rece_codigo }} </td>
                <td class="px-4 py-2"> {{ sal.rece_nombre }} </td>
                <td class="px-4 py-2"> {{ sal.lote_detalle }} </td>
                <td class="px-4 py-2"> {{ sal.cantidad_detalle }} </td>
                <td class="px-4 py-2"> {{ sal.fecha_elaboracion }} </td>
                <td class="px-4 py-2"> {{ sal.fecha_vencimiento }} </td>
                <td class="px-4 py-2"> {{ sal.fecha_envasado }} </td>
            </tr>
        </tbody>
    </table>
</template>


