<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import WarningButton from '@/Components/WarningButton.vue';

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
</script>

<template>
    <Head title="Conocimientos" />

    <AuthenticatedLayout>
        <template #header>
            Solicitudes de Carga Almacenes
        </template>
            <div v-if ="$page.props.user.permissions.includes('create solicitud')" class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
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
                        <tr v-for="sol, i in solicitudAlmacen" :key="sol.id">
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
                                <Link v-if ="sol.estado === 0"
                                :href="route('solicitudAlmacen.edit', sol.id)"
                                class="inline-block rounded-md bg-yellow-400 px-4 py-2 text-white hover:bg-yellow-300 text-sm">
                                <i class="fa-regular fa-square-check fa-lg" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <WarningButton v-if ="$page.props.user.permissions.includes('delete solicitud') && sol.estado === 0"
                                    @click="() => deleteSolicitud(sol.id, sol.fecha)">
                                    <i class="fa-solid fa-trash"></i>
                                </WarningButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </AuthenticatedLayout>
</template>
