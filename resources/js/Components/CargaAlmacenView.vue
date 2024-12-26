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
import BlueButton from '@/Components/BlueButton.vue';

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
const modalSelect = ref(false);
const modalView = ref(false);
const cargaDataView = ref(null);
const selectedCargaIds = ref([]);
const errorMessage = ref('');
const inputValues = ref({}); // Objeto para almacenar las cantidades por ID

const openModalView = async (carga_id) => {
    modalView.value = true;
        try {
            const response = await axios.get(`/sigaSalidaDetalle/viewSelectIds/${carga_id}`);
            cargaDataView.value = response.data; // Guardar los datos en plantaData
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
};

const closeModal = () => {
    modalSelect.value = false;
    modalView.value = false;
    selectedCargaIds.value = [];
    errorMessage.value = '';
    inputValues.value = []; // Usa .value para asignar
}
</script>
<template>
    <InputLabel value="Datos de Solicitud de Carga a Almacen El Alto" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
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
                <th class="px-4 py-2">Estado</th>
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
                <td class="px-4 py-2">
                    <span v-if="car.estado === 0" class="bg-gray-400 px-1 py-1 rounded-md">Vacio</span>
                    <span v-else-if="car.estado === 1" class="bg-green-400 px-1 py-1 rounded-md">Completo</span>
                    <span v-else-if="car.estado === 2" class="bg-red-400 px-1 py-1 rounded-md">SinFechas</span>
                </td>
                <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                    <BlueButton @click="$event=>openModalView(car.id, car.cantidad)">
                        <i class="fa-solid fa-rectangle-list" style="color: #ffffff;"></i>
                    </BlueButton>
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
                <th class="px-4 py-2"></th>
            </tr>
        </tfoot>
    </table>

    <Modal :show="modalView" @close="closeModal">
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider"></div>
                    <h2 class="p-3 text-lg font-medium text-gray-900">Ver Detalle de Fechas</h2>
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
                                    <tr v-for="(carga, index) in cargaDataView" :key="index">
                                        <td class="border border-gray-300 p-2">{{ index + 1 }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.rece_nombre }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.lote_detalle }}</td>
                                        <td class="border border-gray-300 p-2">{{ carga.cantidad_salida }}</td>
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
<style>
.small-input {
    width: 80px; /* Ajusta el tamaño del input según sea necesario */
}
</style>

