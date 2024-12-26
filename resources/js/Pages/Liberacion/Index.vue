<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import BlueButton from '@/Components/BlueButton.vue';

const props = defineProps({
    liberaciones: {
        type: Array,
    }
});

//buscador
const searchQuery = ref('');
const normalizeString = (str) => str.toString().toLowerCase().trim();
const filtered = computed(() => {

    return props.liberaciones.filter(com => {
        return (
            normalizeString(com.libe_factura).includes(normalizeString(searchQuery.value)) ||
            normalizeString(com.created_at).includes(normalizeString(searchQuery.value))
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

<template>
    <Head title="Tracking" />
    <AuthenticatedLayout>
        <template #header>
            Liberacion de Contenedor
        </template>

        <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por nro. factura, fecha de creacion..."
            class="border rounded p-2 mb-4"
            />

            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Nro. Factura
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Fecha de Creacion
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Firmado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Estado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="lib, i in paginated" :key="lib.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ lib.libe_factura }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ new Date(lib.created_at).toLocaleDateString() }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="lib.pdf_cartaliberacion === null" class="bg-red-300 px-2 py-1 rounded-md">No</span>
                                <span v-else-if="lib.pdf_cartaliberacion !== null" class="bg-green-400 px-2 py-1 rounded-md">Si</span>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <span v-if="lib.libe_estado === 0" class="bg-red-300 px-2 py-1 rounded-md">Sin Autorizacion</span>
                                    <span v-else-if="lib.libe_estado === 1" class="bg-blue-400 px-2 py-1 rounded-md">Revisado</span>
                                    <span v-else-if="lib.libe_estado === 2" class="bg-green-400 px-2 py-1 rounded-md">Autorizado</span>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link
                                :href="route('liberacion.show', lib.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
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
    </AuthenticatedLayout>
</template>
