<script>
export default {
    name: 'CargaTable'
}
</script>
<script setup>
import {defineProps, defineEmits, ref} from 'vue';
import { computed } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    cargas: {
        type: Object,
    },
})

const carga = ref(Object.values(props.cargas).map(carga => [
    carga.codigo_producto,
    carga.nombre_producto,
    carga.fecha_produccion,
    carga.descripcion,
    carga.lote,
    carga.cantidad,
    carga.kilosnetos,
    carga.librasnetas,
]))

const totalCantidad = computed(() => carga.value.reduce((acc, current) => acc + current[5], 0))
const totalKilosNetos = computed(() => carga.value.reduce((acc, current) => acc + current[6], 0))
const totalLibrasNetas = computed(() => carga.value.reduce((acc, current) => acc + current[7], 0))
</script>
<template>
    <InputLabel value="Datos de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
    <br>
    <table class="w-full border-collapse font-semibold uppercase">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Codigo</th>
                <th class="px-4 py-2">Tipo</th>
                <th class="px-4 py-2">Fecha de Producción</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Lote</th>
                <th class="px-4 py-2">Cantidad</th>
                <th class="px-4 py-2">Kilos Netos</th>
                <th class="px-4 py-2">Libras Netas</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(_, index) in carga" :key="index" class="border-b">
                <td class="px-4 py-2"> {{ carga[index][0] }} </td>
                <td class="px-4 py-2"> {{ carga[index][1] }} </td>
                <td class="px-4 py-2"> {{ carga[index][2] }} </td>
                <td class="px-4 py-2"> {{ carga[index][3] }} </td>
                <td class="px-4 py-2"> {{ carga[index][4] }} </td>
                <td class="px-4 py-2"> {{ carga[index][5] }} </td>
                <td class="px-4 py-2"> {{ carga[index][6] }} </td>
                <td class="px-4 py-2"> {{ carga[index][7] }} </td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-gray-200">
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2">Totales</th>
                <th class="px-4 py-2">{{ totalCantidad }}</th>
                <th class="px-4 py-2">{{ totalKilosNetos }}</th>
                <th class="px-4 py-2">{{ totalLibrasNetas }}</th>
            </tr>
        </tfoot>
    </table>
</template>


