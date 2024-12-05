<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    comprobanteSalida: {
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
            Comprobantes de Salida
        </template>
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
                                Firmado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                PDF-I
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="com, i in comprobanteSalida" :key="com.id">
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
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="com.pdf_comprobante_salida !== null" class="bg-green-400 px-2 py-1 rounded-md">Si</span>
                                <span v-else-if="com.pdf_comprobante_salida === null" class="bg-red-400 px-2 py-1 rounded-md">No</span>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link :href="route('comprobante_salida.show', com.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <a :href="route('comprobante_salida.pdf', com.id)" target="_blank"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-regular fa-file-pdf" style="color: #ffffff;"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </AuthenticatedLayout>
</template>
