<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import WarningButton from '@/Components/WarningButton.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    solicitudcarga: {
        type: Object,
    }
});
const form = useForm({
    id:''
});

const deleteSolicitud = (id, fecha) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true,
    });
    alerta.fire({
        title:'Esta seguro de eliminar la solictud de carga de fecha '+fecha+ '?',
        icon: 'question',
        showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si, borrar.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result)=>{
        if(result.isConfirmed){
            form.delete(route('solicitudcargas.destroy',id));
        }
    });
}
</script>

<template>
    <Head title="Conocimientos" />

    <AuthenticatedLayout>
        <template #header>
            Solicitudes de Carga
        </template>

            <div v-if ="$page.props.user.permissions.includes('create solicitud')" class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
                <div class="px-4 py-2">
                    <div class="mx-1" >
                        <Link :href="route('solicitudcargas.create')"
                            class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                            <i class="fa-solid fa-clipboard-list px-1" style="color: #ffffff;"></i> Crear Solicitud de Carga
                        </Link>
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
                                 Editar
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Eliminar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="sol, i in solicitudcarga" :key="sol.id">
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
                                <span v-if="sol.estado === 0" class="bg-gray-300 px-2 py-1 rounded-md">Enviado</span>
                                <span v-else-if="sol.estado === 1" class="bg-yellow-400 px-2 py-1 rounded-md">Modificado</span>
                                <span v-else-if="sol.estado === 2" class="bg-blue-400 px-2 py-1 rounded-md">Aceptado</span>
                                <span v-else-if="sol.estado === 3" class="bg-green-400 px-2 py-1 rounded-md">Terminado</span>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link
                                :href="route('solicitudcargas.show', sol.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link v-if ="$page.props.user.permissions.includes('update solicitud') && sol.estado === 0"
                                :href="route('solicitudcargas.edit', sol.id)"
                                class="inline-block rounded-md bg-yellow-400 px-4 py-2 text-white hover:bg-yellow-300 text-sm">
                                <i class="fa-solid fa-chalkboard-user fa-lg" style="color: #ffffff;"></i>
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
