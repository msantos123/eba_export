<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import BlueButton from '@/Components/BlueButton.vue';

const props = defineProps({
    contratos: {
        type: Object,
    }
});

//buscador
const searchQuery = ref('');
const normalizeString = (str) => str.toString().toLowerCase().trim();
const filtered = computed(() => {

    return props.contratos.filter(com => {
        return (
            normalizeString((com.ctrt_codigo ?? '')).includes(normalizeString(searchQuery.value)) ||
            normalizeString(com.ctrt_fecha).includes(normalizeString(searchQuery.value))
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
    <Head title="Contratos" />
    <AuthenticatedLayout>
        <template #header>
            Contratos
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('contratos.create')"
                    class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                    <i class="fa-solid fa-file-circle-plus"></i> Nuevo Contrato
                    </Link>
                </div>
            </div>
        </div>

        <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por codigo contrato, fecha contrato..."
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
                                Codigo Contrato
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Fecha Contrato
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Estado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Firmado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Editar
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                PDF-I
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="con, i in paginated" :key="con.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.ctrt_codigo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.ctrt_fecha }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="con.ctrt_estado === 0" class="bg-gray-300 px-2 py-1 rounded-md">Borrador</span>
                                <span v-else-if="con.ctrt_estado === 1" class="bg-green-400 px-2 py-1 rounded-md">Completo</span></p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="con.pdf_contrato !== null" class="bg-green-400 px-2 py-1 rounded-md">Si</span>
                                <span v-else-if="con.pdf_contrato === null" class="bg-red-400 px-2 py-1 rounded-md">No</span>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link :href="route('contratos.show', con.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link v-if="con.ctrt_estado === 0"  :href="route('contratos.edit', con.id)"
                                class="inline-block rounded-md bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-400 text-sm">
                                <i class="fa-solid fa-edit" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <a :href="route('contratos.pdf', con.id)" target="_blank"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-regular fa-file-pdf" style="color: #ffffff;"></i></a>
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
