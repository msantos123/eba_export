<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import BlueButton from '@/Components/BlueButton.vue';

const props = defineProps({
    kardex: { type: Object }
});

const form = useForm({
    id:''
});

//buscador
const searchQuery = ref('');
const normalizeString = (str) => str.toString().toLowerCase().trim();
const filtered = computed(() => {

    return props.kardex.filter(kar => {
        return (
            normalizeString(kar.codigo_producto).includes(normalizeString(searchQuery.value)) ||
            normalizeString(kar.articulo).includes(normalizeString(searchQuery.value)) ||
            normalizeString(kar.plantas_nombre).includes(normalizeString(searchQuery.value)) ||
            normalizeString(kar.lote).includes(normalizeString(searchQuery.value)) ||
            normalizeString(kar.unidad).includes(normalizeString(searchQuery.value)) ||
            normalizeString(kar.saldo).includes(normalizeString(searchQuery.value))
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
    <Head title="Conocimientos" />
    <AuthenticatedLayout>
        <template #header>
            Kardex
        </template>
            <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por codigo, producto, origen, lote, medida, saldo..."
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
                                Codigo
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Producto
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Origen
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Nro. Lote
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Medida
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Saldo
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="kar, i in paginated" :key="kar.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.codigo_producto }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.articulo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.plantas_nombre }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.lote }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.unidad }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ kar.saldo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link :href="route('kardexs.show', kar.id)"
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
