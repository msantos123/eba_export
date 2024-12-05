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
import BlueButton from '@/Components/BlueButton.vue';
import GreenButton from '@/Components/GreenButton.vue';

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
const cargaData = ref(null);
const cargaDataView = ref(null);
const cargaCantidad = ref(null);
const cargaId = ref(null);
const selectedCargaIds = ref([]);
const errorMessage = ref('');
const inputValues = ref({}); // Objeto para almacenar las cantidades por ID


function handleCheckboxChange(carga) {
    if (!selectedCargaIds.value.includes(carga.id)) {
        carga.inputValue = null;
        carga.error = null; // Resetea el error al deseleccionar
        delete inputValues.value[carga.id]; // Elimina la entrada al deseleccionar
    }
}

function validateInput(carga) {
    if (carga.inputValue > carga.cantidad_detalle) {
        carga.error = `No puede exceder ${carga.cantidad_detalle}`;
    } else {
        carga.error = null; // Limpia el error si es válido
        inputValues.value[carga.id] = carga.inputValue; // Almacena la cantidad en el objeto
    }
            // Agregar console.log aquí
            console.log('inputValues:', inputValues.value);
}

const totalCantidadAlmacen = computed(() => {
    if (!cargaData.value) return 0;
    const total = cargaData.value
        .filter(carga => selectedCargaIds.value.includes(carga.id))
        .reduce((total, carga) => total + (inputValues.value[carga.id] || 0), 0); // Suma las cantidades del objeto

    // Agregar console.log aquí
    console.log('Total Cantidad Almacen:', total);

    return total;
});

const guardarSeleccion = async () => {
    if (totalCantidadAlmacen.value != cargaCantidad.value) {
        errorMessage.value = `Error: La Suma total de (${totalCantidadAlmacen.value})
        es diferente a la cantidad de la solicitud (${cargaCantidad.value}), deben ser
        iguales para cumplir con la solicitud.`;
    } else {
        try {
            const inputArray = Object.entries(inputValues.value).map(([id, cantidad]) => ({ id, cantidad }));
            const response = await axios.get(`/sigaSalidaDetalle/selectIds/${cargaId.value}`, {
                params: { inputs: inputArray }
            });
            closeModal();
            location.reload();
        } catch (error) {
            location.reload();
            console.error('Error al obtener los datos:', error);
        }
    }
};

const openModal = async (carga_id, carga_cantidad) => {
    modalSelect.value = true;
    cargaCantidad.value = carga_cantidad;
    cargaId.value = carga_id;
        try {
            const response = await axios.get(`/sigaSalidaDetalle/selectFechaAlmacen/${carga_id}`);
            cargaData.value = response.data;
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
};

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
                </td>
                <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                    <BlueButton v-if="car.estado === 1 " @click="$event=>openModalView(car.id, car.cantidad)">
                        <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                    </BlueButton>
                    <SecondaryButton v-if="car.estado === 0" @click="$event=>openModal(car.id, car.cantidad)">
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
                <th class="px-4 py-2"></th>
            </tr>
        </tfoot>
    </table>

    <Modal :show="modalSelect" @close="closeModal">
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
                                        <td class="border border-gray-300 p-2">
                                            <input type="number"
                                                v-model="carga.inputValue"
                                                :disabled="!selectedCargaIds.includes(carga.id)"
                                                :class="{'bg-gray-200': !selectedCargaIds.includes(carga.id), 'bg-white': selectedCargaIds.includes(carga.id)}"
                                                class="h-6 py-1 px-1 w-20"
                                                @input="validateInput(carga)" />
                                            <div v-if="carga.error" class="text-red-600 text-sml">{{ carga.error }}</div>
                                        </td>
                                        <td class="border border-gray-300 p-2">
                                            <input type="checkbox"
                                                v-model="selectedCargaIds"
                                                :value="carga.id"
                                                @change="() => handleCheckboxChange(carga)" />
                                        </td>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="border border-gray-300 p-2"></th>
                                        <th class="border border-gray-300 p-2"></th>
                                        <th class="border border-gray-300 p-2"></th>
                                        <th class="border border-gray-300 p-2"></th>
                                        <th class="border border-gray-300 p-2"></th>
                                        <th class="border border-gray-300 p-2"></th>
                                        <th class="border border-gray-300 p-2">Suma total:</th>
                                        <th class="border border-gray-300 p-2">{{ totalCantidadAlmacen }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div v-if="errorMessage" class="text-red-500">{{ errorMessage }}</div>
                            <br>
                            <GreenButton @click="guardarSeleccion">Guardar Selección</GreenButton>
                        </div>
                </div>
            </div>
        </div>
    </Modal>

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

