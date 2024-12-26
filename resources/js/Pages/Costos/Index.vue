<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps, ref, onMounted, watch, computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import GreenButton from '@/Components/GreenButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    kardex: { type: Object },
});

const kardexFiltradoRiberalta = computed(() => {
    // Verifica si inventario es un array antes de filtrar
    return Array.isArray(props.kardex) ? props.kardex.filter(kar => kar.proveedor_id === 9) : [];
});

const kardexFiltradoSena = computed(() => {
    // Verifica si inventario es un array antes de filtrar
    return Array.isArray(props.kardex) ? props.kardex.filter(kar => kar.proveedor_id === 10) : [];
});

const kardexFiltradoCobija = computed(() => {
    // Verifica si inventario es un array antes de filtrar
    return Array.isArray(props.kardex) ? props.kardex.filter(kar => kar.proveedor_id === 25) : [];
});

//modal
const modal = ref(false);
const selectedData = ref({});
const selectedPlanta = ref('');
const form = ref({
    costo_caja: '',
    id: null, // Inicializa el ID
});

const openModal = (data,planta) => {
    console.log(data);
    selectedData.value = data;
    selectedPlanta.value = planta;
    form.value.costo_caja = data.costo_caja;
    form.value.id = data.id;
    modal.value = true
};
const closeModal = () => {
    modal.value = false;
    selectedData.value = {};
    selectedPlanta.value = '';
    form.value.costo_caja = '';
    form.value.id = null;
};

//save
const saveCosto = () => {
    axios.post(route('costos.update_costo'), {
        id: form.value.id,
        costo_caja: form.value.costo_caja,
    })
    .then(response => {
        console.log(response); // Manejar la respuesta
        // Mostrar swal en caso de éxito
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: response.data.message || 'Datos guardados exitosamente.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            closeModal();
            window.location.reload();
        });
    })
    .catch(error => {
        console.error(error.response); // Manejar errores
        // Mostrar swal en caso de error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al guardar los datos.',
            confirmButtonText: 'Aceptar'
        });
    });
};
</script>

<template>
    <Head title="Contratos" />
    <AuthenticatedLayout>
        <template #header>
            Costos
        </template>
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-1 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Codigo
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Lote
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Producto
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Costo
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Estado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver Detalle
                            </th>
                        </tr>
                    </thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th colspan="7" class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Planta Industrial Riberalta
                        </th>
                    </tr>
                    <tbody>
                        <tr v-for="(kar, i) in kardexFiltradoRiberalta" :key="kar.proveedor_id">
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.codigo_producto }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.lote }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.articulo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.costo_caja }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="kar.costo_caja === null" class="bg-red-400 px-2 py-1 rounded-md">Sin Costo</span>
                                <span v-else-if="kar.costo_caja !== null" class="bg-green-400 px-2 py-1 rounded-md">Completo</span></p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <GreenButton v-if ="$page.props.user.permissions.includes('Agregar Costo Lote') && kar.costo_caja === null" @click="openModal(kar, 'Planta Industrial Riberalta')"
                                    class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                                    <i class="fa-solid fa-coins" style="color: #ffffff;"></i>
                                    </GreenButton>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th colspan="7" class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Planta Industrial Sena
                        </th>
                    </tr>
                    <tbody>
                        <tr v-for="(kar, i) in kardexFiltradoSena" :key="kar.proveedor_id">
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.codigo_producto }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.lote }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.articulo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.costo_caja }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="kar.costo_caja === null" class="bg-red-400 px-2 py-1 rounded-md">Sin Costo</span>
                                <span v-else-if="kar.costo_caja !== null" class="bg-green-400 px-2 py-1 rounded-md">Completo</span></p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <GreenButton v-if ="$page.props.user.permissions.includes('Agregar Costo Lote') && kar.costo_caja === null" @click="openModal(kar, 'Planta Industrial Sena')"
                                    class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                                    <i class="fa-solid fa-coins" style="color: #ffffff;"></i>
                                    </GreenButton>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th colspan="7" class="border-b-2 border-gray-200 bg-gray-100 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Planta Industrial Cobija
                        </th>
                    </tr>
                    <tbody>
                        <tr v-for="(kar, i) in kardexFiltradoCobija" :key="kar.proveedor_id">
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.codigo_producto }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.lote }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.articulo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.costo_caja }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="kar.costo_caja === null" class="bg-red-400 px-2 py-1 rounded-md">Sin Costo</span>
                                <span v-else-if="kar.costo_caja !== null" class="bg-green-400 px-2 py-1 rounded-md">Completo</span></p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-1 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <GreenButton v-if ="$page.props.user.permissions.includes('Agregar Costo Lote') && kar.costo_caja === null" @click="openModal(kar, 'Planta Industrial Cobija')"
                                    class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                                    <i class="fa-solid fa-coins" style="color: #ffffff;"></i>
                                    </GreenButton>
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
                    <h2 class="p-3 text-lg font-medium text-gray-900">Costo de Lote</h2>
                        <form @submit.prevent="saveCosto">
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <InputLabel value="Planta de Producción"></InputLabel>
                                </div>
                                <div>
                                    <TextDisabled  :value="selectedPlanta" type="text" class="mt-2 block w-full"></TextDisabled>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <InputLabel value="Producto"></InputLabel>
                                </div>
                                <div>
                                    <TextDisabled :value="selectedData.articulo" type="text" class="mt-2 block w-full"></TextDisabled>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <InputLabel value="Nro. de Lote"></InputLabel>
                                </div>
                                <div>
                                    <TextDisabled :value="selectedData.lote" type="number" class="mt-2 block w-full"></TextDisabled>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <InputLabel value="Costo por Caja"></InputLabel>
                                </div>
                                <div>
                                    <TextInput v-model="form.costo_caja" type="number" class="mt-2 block w-full"></TextInput>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <GreenButton type="submit"
                                    class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                                    <i class="fa-solid fa-save" style="color: #ffffff;"></i> Guardar y salir
                                    </GreenButton>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
    </AuthenticatedLayout>
</template>
