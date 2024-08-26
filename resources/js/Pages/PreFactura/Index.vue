<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import WarningButton from '@/Components/WarningButton.vue';

const props = defineProps({
    kardex: {
        type: Object,
    }
});

const deleteSolicitud = (id, planta) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true,
    });
    alerta.fire({
        title:'Esta seguro de eliminar la solictud de carga de '+planta+ '?',
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

const ok = (msj) => {
    form.reset();
    Swal.fire({title:msj,icon:'success'});
}
</script>

<template>
    <Head title="Conocimientos" />

    <AuthenticatedLayout>
        <template #header>
            Solicitudes de Carga
        </template>

            <div v-if="$page.props.auth.user.rol == 2" class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
                <div class="-mx-3 px-4 py-2">
                    <div class="mx-3" >
                        <Link :href="route('solicitudcargas.create')"
                            class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                            <i class="fa-solid fa-clipboard-list px-1" style="color: #ffffff;"></i> Solicitar
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
                                 Ver / Editar
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
                                <span v-if="sol.estado === 0" class="bg-gray-300 px-2 py-1 rounded-md">Borrador</span>
                                <span v-else-if="sol.estado === 1" class="bg-blue-400 px-2 py-1 rounded-md">Enviado</span>
                                <span v-else-if="sol.estado === 2" class="bg-green-400 px-2 py-1 rounded-md">Recibido</span>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                    <Link v-if="$page.props.auth.user.rol === 2 && !(sol.estado == 1 || sol.estado == 2)"
                                    :href="route('solicitudcargas.edit', sol.id)"
                                    class="inline-block rounded-md bg-yellow-400 px-4 py-2 text-white hover:bg-yellow-300 text-sm">
                                    <i class="fa-solid fa-chalkboard-user fa-lg" style="color: #ffffff;"></i>
                                    </Link>
                                    <Link v-if="$page.props.auth.user.rol === 4 && sol.estado == 1"
                                    :href="route('solicitudcargas.edit', sol.id)"
                                    class="inline-block rounded-md bg-yellow-400 px-4 py-2 text-white hover:bg-yellow-300 text-sm">
                                    <i class="fa-solid fa-chalkboard-user fa-lg" style="color: #ffffff;"></i>
                                    </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <WarningButton v-if="$page.props.auth.user.rol === 2 && !(sol.estado == 1 || sol.estado == 2)"
                                    @click="() => deleteSolicitud(sol.id, sol.planta)">
                                    <i class="fa-solid fa-trash"></i>
                                </WarningButton>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </AuthenticatedLayout>
</template>
