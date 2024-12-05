<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    pre_factura: {
        type: Object,
    }
});

const form = useForm({
    id:''
});

</script>

<template>
    <Head title="Conocimientos" />

    <AuthenticatedLayout>
        <template #header>
            Pre Factura
        </template>
            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                ID
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Nro. Factura
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Fecha Factura
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Razon Social
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Lugar Destino
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Zafra
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Anulado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pre, i in pre_factura" :key="pre.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pre.id }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pre.nro_factura }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pre.fecha_factura }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pre.razon_social }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pre.lugar_destino }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ pre.zafra }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="pre.anulado === 1" class="bg-green-400 px-2 py-1 rounded-md">Si</span>
                                <span v-else-if="pre.anulado === 0" class="bg-red-400 px-2 py-1 rounded-md">No</span>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link :href="route('pre_factura.show', pre.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </AuthenticatedLayout>
</template>
