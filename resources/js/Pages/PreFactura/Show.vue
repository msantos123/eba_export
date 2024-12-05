<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextDisabled from '@/Components/TextDisabled.vue';

const props = defineProps({
    pre_factura: { type: Object },
});

const getPlantaText = () => {
    switch (form.planta_id) {
        case 9:
            return 'Planta Industrial Riberalta';
        case 10:
            return 'Planta Industrial Sena';
        case 25:
            return 'Planta Industrial Cobija';
        default:
            return 'Desconocido'; // Manejo de un valor no esperado
    }
};

const form = useForm({
    //pre_factura
    id:props.pre_factura.id,
    mes:props.pre_factura.mes,
    fecha_factura:props.pre_factura.fecha_factura,
    nro_factura:props.pre_factura.nro_factura,
    razon_social:props.pre_factura.razon_social,
    nit:props.pre_factura.nit,
    incoterm:props.pre_factura.incoterm,
    lugar_destino:props.pre_factura.lugar_destino,
    puerto_destino:props.pre_factura.puerto_destino,
    direccion:props.pre_factura.direccion,
    zafra:props.pre_factura.zafra,
    total_facturado_usd:props.pre_factura.total_facturado_usd,
    total_facturado_bs:props.pre_factura.total_facturado_bs,
    comision:props.pre_factura.comision,
    total_pagar_usd:props.pre_factura.total_pagar_usd,
    total_pagar_bs:props.pre_factura.total_pagar_bs,
    primer_pago:props.pre_factura.primer_pago,
    fecha_primer_pago:props.pre_factura.fecha_primer_pago,
    segundo_pago:props.pre_factura.segundo_pago,
    fecha_segundo_pago:props.pre_factura.fecha_segundo_pago,
    tercer_pago:props.pre_factura.tercer_pago,
    fecha_tercer_pago:props.pre_factura.fecha_tercer_pago,
    total_pagos:props.pre_factura.total_pagos,
    saldos:props.pre_factura.saldos,
    anulado:props.pre_factura.anulado,
    //datos comprobante_salida
    id_salida:props.pre_factura.comprobante_salida.id,
    fecha_salida:props.pre_factura.comprobante_salida.fecha_salida,
    empresa:props.pre_factura.comprobante_salida.empresa,
    responsable:props.pre_factura.comprobante_salida.responsable,
    camion:props.pre_factura.comprobante_salida.camion,
    placa:props.pre_factura.comprobante_salida.placa,
    licencia:props.pre_factura.comprobante_salida.licencia,
    celular:props.pre_factura.comprobante_salida.celular,
    contenedor:props.pre_factura.comprobante_salida.contenedor,
    presinto:props.pre_factura.comprobante_salida.presinto,
    reserva:props.pre_factura.comprobante_salida.reserva,
    factura:props.pre_factura.comprobante_salida.factura,
    destino:props.pre_factura.comprobante_salida.destino,
    codigo_salida:props.pre_factura.comprobante_salida.codigo_salida,
    pdf_comprobante_salida:props.pre_factura.comprobante_salida.pdf_comprobante_salida,
    liberacion:props.pre_factura.comprobante_salida.liberacion,
    //datos de solictud almacen
    id_solicitud:props.pre_factura.comprobante_salida.solicitud_carga.id,
    codigo:props.pre_factura.comprobante_salida.solicitud_carga.codigo,
    planta_id:props.pre_factura.comprobante_salida.solicitud_carga.planta_id,
});
</script>

<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            Ver Pre Factura
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('pre_factura.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
            </div>
        </div>
            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <div class="w-full whitespace-no-wrap">
                    <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                        <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                            <InputLabel value="Datos Pre Factura" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-4 gap-4 mt-4">
                                <div>
                                    <InputLabel value="ID"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.id" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="MES"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.mes" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="FECHA FACTURA"></InputLabel>
                                    <TextDisabled type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_factura" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="NRO. FACTURA"></InputLabel>
                                    <TextDisabled list="form.destino" type="text" class="mt-2 block w-full"
                                    v-model="form.nro_factura" disabled/>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="RAZON SOCIAL"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.razon_social" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="NIT"/>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.nit" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="INCOTERM"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.incoterm" disabled/>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mt-4">
                                <div>
                                    <InputLabel value="LUGAR DE DESTINO"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.lugar_destino" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="PUERTO DESTINO"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.puerto_destino" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="DIRECCION"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.direccion" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="ZAFRA"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.zafra" disabled/>
                                </div>
                            </div>
                            <div class="grid grid-cols-5 gap-4 mt-4">
                                <div>
                                    <InputLabel value="TOTAL FACTURADO USD"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.total_facturado_usd" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="TOTAL FACTURADO BS"/>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.total_facturado_bs" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="COMISION"/>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.comision" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="TOTAL PAGADO USD"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.total_pagar_usd" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="TOTAL PAGADO BS"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.total_pagar_bs" disabled/>
                                </div>
                            </div>
                            <div class="grid grid-cols-6 gap-4 mt-4">
                                <div>
                                    <InputLabel value="PRIMER PAGO"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.primer_pago" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="FECHA PRIMER PAGO"/>
                                    <TextDisabled type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_primer_pago" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="SEGUNDO PAGO"/>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.segundo_pago" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="FECHA SEGUNDO PAGO"></InputLabel>
                                    <TextDisabled type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_segundo_pago" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="TERCER PAGO"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.tercer_pago" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="FECHA TERCER PAGO"></InputLabel>
                                    <TextDisabled type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_tercer_pago" disabled/>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="TOTAL PAGADO"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.total_pagos" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="TOTAL FACTURADO BS"/>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.saldos" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="ANULADO"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    :value="form.anulado === 1 ? 'Sí' : 'No'"  disabled/>
                                </div>
                            </div>
                            <br>
                            <InputLabel value="Datos Solicitud de Almacen" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="ID"/>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.id_solicitud" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="CODIGO"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.codigo" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="PLANTA INDUSTRIAL"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    :value="getPlantaText()" disabled/>
                                </div>
                            </div>
                            <br>
                            <InputLabel value="Datos de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            ID
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            CODIGO
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                           NOMBRE PRODUCTO
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            LOTE
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            CANTIDAD
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            KILOS
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            LIBRAS
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            PRECIO KG
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            PRECIO LB
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="car, i in pre_factura.comprobante_salida.solicitud_carga.cargas" :key="car.id">
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.id }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.codigo_producto }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.nombre_producto }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.lote }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.cantidad }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.kilosnetos }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.librasnetas }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.precio_kilo }}</p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ car.precio_libra }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>
