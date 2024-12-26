<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import WarningButton from '@/Components/WarningButton.vue';
import { ref, defineProps, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import BlueButton from '@/Components/BlueButton.vue';

const props = defineProps({
    solicitudAlmacen: { type: Object },
    plantas: { type: Object },
});
const form = useForm({
    id:''
});

const deleteSolicitud = (id, fecha) => {
    Swal.fire({
        title: '¿Está seguro de eliminar la solicitud de carga de fecha ' + fecha + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Si, borrar.',
        cancelButtonText: 'Cancelar',
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.delete(route('solicitudcargas.delete', id));

                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: response.data.success,
                }).then(() => {
                    // Recargar la página solo después de que el usuario cierre el mensaje de éxito
                    location.reload();
                });

                // Opcional: recargar la página para reflejar cambios
                location.reload();
            } catch (error) {
                console.error('Error al eliminar la solicitud:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar la solicitud. Inténtelo de nuevo más tarde.'
                });
            }
        }
    });
};

//buscador
const searchQuery = ref('');
const normalizeString = (str) => str.toString().toLowerCase().trim();
const filtered = computed(() => {

    return props.solicitudAlmacen.filter(sol => {
        return (
            normalizeString((sol.codigo ?? '')).includes(normalizeString(searchQuery.value)) ||
            normalizeString(sol.fecha).includes(normalizeString(searchQuery.value)) ||
            normalizeString(sol.usuario).includes(normalizeString(searchQuery.value)) ||
            normalizeString(sol.planta).includes(normalizeString(searchQuery.value)) ||
            normalizeString(sol.total_cantidad).includes(normalizeString(searchQuery.value)) ||
            normalizeString(sol.total_kilosnetos).includes(normalizeString(searchQuery.value)) ||
            normalizeString(sol.total_librasnetas).includes(normalizeString(searchQuery.value))
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
            Solicitudes de Carga Almacenes
        </template>
            <div  class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md"
            >
                <div class="px-4 py-2">
                    <div class="flex flex-wrap mx-1">
                        <div v-for="planta in props.plantas" :key="planta.planta_id" class="mr-2 mb-2">
                            <Link :href="route('solicitudAlmacen.create', planta.planta_id)"
                            class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                            <i class="fa-solid fa-industry" style="color: #ffffff;"></i> {{ planta.nombre }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <TextInput
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por codigo, fecha, usuario, planta, total cajas, total kilos netos, total libras netas..."
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
                                Fecha
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Usuario Solicitante
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Planta
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Total Cajas
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Total Kilos Netos
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Total Libras Netas
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Estado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                 Ver
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                 Select
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Eliminar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sol, i in paginated" :key="sol.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ (i+1) }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ sol.codigo }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ sol.fecha }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ sol.usuario }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ sol.planta }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ sol.total_cantidad }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ sol.total_kilosnetos }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                {{ sol.total_librasnetas }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <span v-if="sol.estado === 0" class="bg-green-400 px-2 py-1 rounded-md">Enviado</span>
                                <span v-else-if="sol.estado === 1" class="bg-yellow-400 px-2 py-1 rounded-md">Recibido</span>
                                <span v-else-if="sol.estado === 2" class="bg-blue-400 px-2 py-1 rounded-md">Terminado</span>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link
                                :href="route('solicitudAlmacen.show', sol.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link v-if ="$page.props.user.permissions.includes('Modificar Solicitud Almacen') && sol.estado === 0"
                                :href="route('solicitudAlmacen.edit', sol.id)"
                                class="inline-block rounded-md bg-yellow-400 px-4 py-2 text-white hover:bg-yellow-300 text-sm">
                                <i class="fa-regular fa-square-check fa-lg" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <WarningButton v-if ="$page.props.user.permissions.includes('Eliminar Solicitud Almacen') && sol.estado === 0"
                                    @click="() => deleteSolicitud(sol.id, sol.fecha)">
                                    <i class="fa-solid fa-trash"></i>
                                </WarningButton>
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
