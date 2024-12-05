<script>
export default {
    name: 'CargaTable'
}
</script>
<script setup>
import {defineProps, ref} from 'vue';
import { computed } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from './SecondaryButton.vue';

const props = defineProps({
    cargas: {
        type: Object,
    },
})

const carga = ref(Object.values(props.cargas).map(carga => [
    carga.codigo_producto,
    carga.nombre_producto,
    carga.lote,
    carga.descripcion,
    carga.cantidad,
    carga.kilosnetos,
    carga.librasnetas,
]))

const totalCantidad = computed(() => carga.value.reduce((acc, current) => acc + current[4], 0))
const totalKilosNetos = computed(() => carga.value.reduce((acc, current) => acc + parseFloat(current[5] || 0), 0))
const totalLibrasNetas = computed(() => carga.value.reduce((acc, current) => acc + parseFloat(current[6] || 0), 0))

//codigo del modal
const modal = ref(false);
const title = ref('');
const cargaData = ref(null); // Para almacenar los datos del registro
const operation = ref(null);
const cantidad_total = ref(null);

const openModal = async (id, op) => {
    modal.value = true;
    operation.value = op;
        try {
            const response = await axios.get(`/sigaSalidaDetalle/verCargaDetalle/${id}`);
            cargaData.value = response.data; // Guardar los datos en plantaData
            console.log(cargaData);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
};

const closeModal = () => {
        modal.value = false;
    }
</script>
<template>
    <InputLabel value="Datos de Solcitud de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
    <br>

    <table class="w-full border-collapse font-semibold uppercase">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Codigo</th>
                <th class="px-4 py-2">Producto</th>
                <th class="px-4 py-2">Lote</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Cantidad</th>
                <th class="px-4 py-2">Kilos Netos</th>
                <th class="px-4 py-2">Libras Netas</th>
                <th class="px-4 py-2">Ver Detalle</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="car, i in cargas" :key="car.id" class="border-b">
                <td class="px-4 py-2"> {{ car.codigo_producto }} </td>
                <td class="px-4 py-2"> {{ car.nombre_producto }} </td>
                <td class="px-4 py-2"> {{ car.lote }} </td>
                <td class="px-4 py-2"> {{ car.descripcion }} </td>
                <td class="px-4 py-2"> {{ car.cantidad }} </td>
                <td class="px-4 py-2"> {{ car.kilosnetos }} </td>
                <td class="px-4 py-2"> {{ car.librasnetas }} </td>
                <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                    <SecondaryButton @click="$event=>openModal(car.id)">
                        <i class="fa-solid fa-rectangle-list" style="color: #ffffff;"></i>
                    </SecondaryButton>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-gray-200">
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2">Totales</th>
                <th class="px-4 py-2">{{ totalCantidad }}</th>
                <th class="px-4 py-2">{{ totalKilosNetos }}</th>
                <th class="px-4 py-2">{{ totalLibrasNetas }}</th>
                <th class="px-4 py-2"></th>
            </tr>
        </tfoot>
    </table>

    <Modal :show="modal" @close="closeModal">
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider"></div>
                    <h2 class="p-3 text-lg font-medium text-gray-900">Detalle de Salida de Planta</h2>
                        <div class="p-3">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 p-2">#</th>
                                        <th class="border border-gray-300 p-2">Producto</th>
                                        <th class="border border-gray-300 p-2">Nro. Lote</th>
                                        <th class="border border-gray-300 p-2">Cantidad</th>
                                        <th class="border border-gray-300 p-2">Fecha Elaboracion</th>
                                        <th class="border border-gray-300 p-2">Fecha Envasado</th>
                                        <th class="border border-gray-300 p-2">Fecha Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(carga, index) in cargaData" :key="index">
                                        <td class="border border-gray-300 p-2">{{ index + 1 }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.rece_nombre }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.lote_detalle }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.cantidad_detalle }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.fecha_elaboracion }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.fecha_envasado }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.fecha_vencimiento }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </Modal>
</template>


