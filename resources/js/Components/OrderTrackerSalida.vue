<template>

    <div>
        <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por fecha de salida, codigo salida, factura, destino, contenedor..."
            class="border rounded p-2 mb-4"
            />
        <InputLabel value="Lista de Salida de Contendor" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Fecha de Salida
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Codigo Salida
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Factura
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Destino
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Contenedor
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Doc Liberacion
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Doc
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="com, i in paginated" :key="com.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.fecha_salida }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.codigo_salida }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.factura }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.destino }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.contenedor }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="com.liberacion === 0" class="bg-red-400 px-2 py-1 rounded-md">No</span>
                                <span v-else-if="com.liberacion === 1" class="bg-green-400 px-2 py-1 rounded-md">Si</span></p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <BlueButton @click="$event=>openModalTracking(com.contenedor)">
                                    <i class="fa-solid fa-location-dot"></i>
                                </BlueButton>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <Link v-if="com.liberacion === 0" :href="route('tracking.show', com.id)"
                                class="inline-block rounded-md bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-400 text-sm">
                                <i class="fa-solid fa-file-invoice" style="color: #ffffff;"></i></Link>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4 flex justify-center border-b border-gray-200 bg-white px-3 py-3 text-sm">
                    <BlueButton
                        @click="goToPage(currentPage - 1)"
                        :disabled="currentPage === 1"
                        class="px-4 py-2"
                    >
                        Anterior
                    </BlueButton>
                    <span class="mx-2 py-2">
                        Página {{ currentPage }} de {{ totalPages }}
                    </span>
                    <BlueButton
                        @click="goToPage(currentPage + 1)"
                        :disabled="currentPage === totalPages.value"
                        class="px-4 py-2 "
                    >
                        Siguiente
                    </BlueButton>
                </div>

            </div>
        <Modal :show="modalTracking" @close="closeModal">
            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <div class="w-full whitespace-no-wrap">
                    <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                        <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                            <div id="ordertracker-widget"></div>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>

    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import BlueButton from '@/Components/BlueButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    comprobanteSalidas: {
        type: Object,
    }
});
const modalTracking = ref(false);
const trackingInfo = ref({});

const openModalTracking = async (contenedor) => {
    modalTracking.value = true;
    const script = document.createElement('script');
    script.src = 'https://www.ordertracker.com/sdk.js';
    script.async = true;
    script.onload = () => {
        console.log('Ordertracker script loaded'); // Verifica que el script se cargue
        if (typeof Ordertracker === 'undefined') {
            console.error('Ordertracker is not defined');
            return;
        }
        Ordertracker({
            id: "670e6ee49e0a4b036d860883",
             // Usar una función separada para manejar la actualización

            // Uncomment and replace YOUR_TRACKING_NUMBER if needed
            trackingNumber: contenedor,
        }).render('#ordertracker-widget');
    };
    document.body.appendChild(script);
};

const closeModal = () => {
    modalTracking.value = false;
}

//buscador
const searchQuery = ref('');
const normalizeString = (str) => str.toString().toLowerCase().trim();
const filtered = computed(() => {

    return props.comprobanteSalidas.filter(com => {
        return (
            normalizeString(com.fecha_salida).includes(normalizeString(searchQuery.value)) ||
            normalizeString(com.codigo_salida).includes(normalizeString(searchQuery.value)) ||
            normalizeString(com.factura).includes(normalizeString(searchQuery.value)) ||
            normalizeString(com.destino).includes(normalizeString(searchQuery.value)) ||
            normalizeString(com.contenedor).includes(normalizeString(searchQuery.value))
        );

    });

});

//paginacion
const currentPage = ref(1);
const itemsPerPage = ref(10);
// Propiedad computada para paginar
const paginated = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filtered.value.slice(start, start + itemsPerPage.value);
});

// Calcular el total de páginas
const totalPages = computed(() => {
    return Math.ceil(filtered.value.length / itemsPerPage.value);
});

// Navegación de páginas
const goToPage = (page) => {
    if (page > 0 && page <= totalPages.value) {
        currentPage.value = page;
    }
};
</script>

<style>
/* Agrega tu estilo aquí si es necesario */
</style>
