<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    comprobanteIngreso: {
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
            Comprobantes de Ingreso
        </template>

            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Fecha de Ingreso
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Codigo Ingreso
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Nro. CEFO
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Procedencia
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Codigo<br>
                                Conocimiento
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Estado
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600">
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
                        <tr v-for="com, i in comprobanteIngreso" :key="com.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.fecha_ingreso }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.codigo_ingreso }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.cefo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.plantas_nombre }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.codigo }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="com.estado === 0" class="bg-green-400 px-2 py-1 rounded-md">Recibido</span>
                                <span v-else-if="com.estado === 1" class="bg-blue-400 px-2 py-1 rounded-md">Ingresado</span>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                <span v-if="com.pdf_comprobante_ingreso !== null" class="bg-green-400 px-2 py-1 rounded-md">Si</span>
                                <span v-else-if="com.pdf_comprobante_ingreso === null" class="bg-red-400 px-2 py-1 rounded-md">No</span>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <Link :href="route('comprobante_ingreso.edit', com.id)"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </Link>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <a :href="route('comprobante_ingreso.pdf', com.id)" target="_blank"
                                class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                                <i class="fa-regular fa-file-pdf" style="color: #ffffff;"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </AuthenticatedLayout>
</template>
