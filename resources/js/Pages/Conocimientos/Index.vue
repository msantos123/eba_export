<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';

const props = defineProps({
    conocimientos: {
        type: Object,
    }
});

const form = useForm({
    id:''
});

const ok = (msj) => {
    form.reset();
    Swal.fire({title:msj,icon:'success'});
}

const ingreso = (id, codigo) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true,
    });
    alerta.fire({
        title:'Esta seguro que desea recibir la carga con '+codigo+'?',
        icon: 'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i> Si.',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
    }).then((result)=>{
        if(result.isConfirmed){
            form.get(route('comprobante_ingreso.show',id),{
                onSuccess: () => {ok('Carga Recibida')}
            });
        }
    });
}

</script>

<template>
    <Head title="Conocimientos" />

    <AuthenticatedLayout>
        <template #header>
            Conocimientos de Carga
        </template>
            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Planta
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Codigo
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Empresa
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Conductor
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Vehiculo
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Placa
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Celular
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
                                PDF
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="con, i in conocimientos" :key="con.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.plantaNombre }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.codigo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.empresa }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.conductor }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.vehiculo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.placa }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ con.celular }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="con.estado === 0" class="bg-gray-300 px-2 py-1 rounded-md">Borrador</span>
                                <span v-else-if="con.estado === 1" class="bg-blue-400 px-2 py-1 rounded-md">Enviado</span>
                                <span v-else-if="con.estado === 2" class="bg-green-400 px-2 py-1 rounded-md">Recibido</span></p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link
                                :href="route('conocimientos.show', con.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link v-if ="$page.props.user.permissions.includes('update conocimiento') && con.estado === 0"
                                :href="route('conocimientos.edit', con.id)"
                                class="inline-block rounded-md bg-yellow-400 px-4 py-2 text-white hover:bg-yellow-300 text-sm">
                                <i class="fa-solid fa-chalkboard-user fa-lg" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                    <a v-if ="$page.props.user.permissions.includes('pdf conocimiento') && con.estado === 1" :href="route('conocimientos.pdf', con.id)" target="_blank"
                                    class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                    <i class="fa-regular fa-file-pdf fa-lg" style="color: #ffffff;"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </AuthenticatedLayout>
</template>
