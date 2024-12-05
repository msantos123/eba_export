<script>
export default {
    name: 'ProductoInventario'
}
</script>

<script setup>
import { defineProps, computed, ref  } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '../Modal.vue';
import BlueButton from '../BlueButton.vue';

const props = defineProps({
    inventario: {
        type: Array,
        required: true,
    },
})

const form = useForm({
    inventario:props.inventario,
});

const inventarioFiltradoRiberalta = computed(() => {
    // Verifica si inventario es un array antes de filtrar
    return Array.isArray(props.inventario) ? props.inventario.filter(inv => inv.skpt_planta_id === 9) : [];
});

const inventarioFiltradoSena = computed(() => {
    // Verifica si inventario es un array antes de filtrar
    return Array.isArray(props.inventario) ? props.inventario.filter(inv => inv.skpt_planta_id === 10) : [];
});

const inventarioFiltradoCobija = computed(() => {
    // Verifica si inventario es un array antes de filtrar
    return Array.isArray(props.inventario) ? props.inventario.filter(inv => inv.skpt_planta_id === 25) : [];
});

//modal
const modal = ref(false);
const showInventario = ref([]);

const openModal = async (receta, planta) => {
    modal.value = true;
    try {
        const response = await axios.get(route('inventario.show', { producto: receta, planta: planta }));
        showInventario.value = response.data;
        console.log(response.data); // Manejar la respuesta
    } catch (error) {
        if (error.response) {
            // La solicitud se realizó y el servidor respondió con un código de estado que no está en el rango de 2xx
            console.error('Error en la respuesta del servidor:', error.response.data);
            console.error('Código de estado:', error.response.status);
        } else if (error.request) {
            // La solicitud se realizó pero no se recibió respuesta
            console.error('No se recibió respuesta:', error.request);
        } else {
            // Algo sucedió al configurar la solicitud
            console.error('Error al configurar la solicitud:', error.message);
        }
    }
};

const closeModal = () => {
    modal.value = false;
    showInventario.value = []; // Limpia los datos al cerrar el modal, si es necesario
};
</script>
<template>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-1 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Producto
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Cantidad
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver Detalle
                            </th>
                        </tr>
                    </thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th colspan="4" class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Planta Industrial Riberalta
                        </th>
                    </tr>
                    <tbody>
                        <tr v-for="(inv, i) in inventarioFiltradoRiberalta" :key="inv.skpt_rece_id">
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ inv.rece_nombre }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ inv.total_cantidad }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <BlueButton @click="openModal(inv.skpt_rece_id, inv.skpt_planta_id)">
                                        <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                    </BlueButton>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th colspan="4" class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Planta Industrial Sena
                        </th>
                    </tr>
                    <tbody>
                        <tr v-for="(inv, i) in inventarioFiltradoSena" :key="inv.skpt_rece_id">
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ inv.rece_nombre }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ inv.total_cantidad }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <BlueButton @click="openModal(inv.skpt_rece_id, inv.skpt_planta_id)">
                                        <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                    </BlueButton>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th colspan="4" class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Planta Industrial Cobija
                        </th>
                    </tr>
                    <tbody>
                        <tr v-for="(inv, i) in inventarioFiltradoCobija" :key="inv.skpt_rece_id">
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ inv.rece_nombre }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ inv.total_cantidad }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <BlueButton @click="openModal(inv.skpt_rece_id, inv.skpt_planta_id)">
                                        <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                    </BlueButton>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    <Modal :show="modal" @close="closeModal">
        <div class="min-w-md overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <h2 class="p-3 text-lg font-medium text-gray-900">Detalle de Producto</h2>
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        #
                                    </th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Codigo
                                    </th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Producto
                                    </th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Lote
                                    </th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Cantidad
                                    </th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Fecha Elaboracion
                                    </th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Fecha Vencimiento
                                    </th>
                                    <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Fecha Actualización
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(inv, i) in showInventario">
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                                    </td>
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ inv.rece_codigo }}</p>
                                    </td>
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ inv.rece_nombre }}</p>
                                    </td>
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ inv.skpt_lote }}</p>
                                    </td>
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ inv.skpt_cantidad }}</p>
                                    </td>
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ inv.skpt_fec_elaboracion }}</p>
                                    </td>
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ inv.skpt_fec_vencimiento }}</p>
                                    </td>
                                    <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ new Date(inv.updated_at).toLocaleDateString() }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
