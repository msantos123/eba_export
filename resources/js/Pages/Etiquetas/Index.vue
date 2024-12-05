<script setup>
import BlueButton from '@/Components/BlueButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    comprobanteSalida: {
        type: Object,
    }
});

const form = useForm({
    salidas:[],
});

const verListaCarga = () => {
  const salidas = props.comprobanteSalida.flatMap(com =>
    com.solicitud_cargas.flatMap(solicitud =>
      solicitud.cargas.map(salida => salida.id)
    )
  );
  form.salidas = salidas;
  form.nro_factura = props.comprobanteSalida.factura;
  form.get(route('etiquetas.cargasEtiqueta',salidas), {
  });
};
</script>

<template>
    <Head title="Conocimientos" />
    <AuthenticatedLayout>
        <template #header>
            Etiquetas
        </template>
            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                #
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Factura
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Destino
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Codigo Solicitud
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Lotes
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Ver
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="com, i in comprobanteSalida" :key="com.id">
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (i+1) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.factura }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ com.destino }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <ul>
                                    <li v-for = "sol in com.solicitud_cargas" :key = "sol.id">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ sol.codigo }}
                                        </p>
                                    </li>
                                </ul>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                <ul>
                                    <li v-for="solicitud in com.solicitud_cargas" :key="solicitud.id">
                                        <ul>
                                            <li v-for="car in solicitud.cargas" :key="car.id">
                                             - {{ car.lote }}
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-3 text-sm">
                                <BlueButton @click="() => verListaCarga()">
                                    <i class="fa-solid fa-tags fa-lg" style="color: #ffffff;"></i>
                                </BlueButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </AuthenticatedLayout>
</template>
