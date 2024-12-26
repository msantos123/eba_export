<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref , watch} from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import TextInput from '@/Components/TextInput.vue';
import BlueButton from '@/Components/BlueButton.vue';
import InputError from '@/Components/InputError.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
    comprobante_salida: { type: Object },
});

const form = useForm({
    //pre_factura
    id:'',//props.pre_factura.id,
    mes:'',//props.pre_factura.mes,
    fecha_factura:'',//props.pre_factura.fecha_factura,
    nro_factura:'',//props.pre_factura.nro_factura,
    razon_social:'',//props.pre_factura.razon_social,
    nit:'',//props.pre_factura.nit,
    incoterm:'',//props.pre_factura.incoterm,
    lugar_destino:'',//props.pre_factura.lugar_destino,
    puerto_destino:'',//props.pre_factura.puerto_destino,
    direccion:'',//props.pre_factura.direccion,
    zafra:'2024',//props.pre_factura.zafra,
    total_facturado_usd: 0,//props.pre_factura.total_facturado_usd,
    total_facturado_bs: 0,//props.pre_factura.total_facturado_bs,
    comisionPorcentaje: 0,
    comision: 0,//props.pre_factura.comision,
    total_pagar_usd: 0,//props.pre_factura.total_pagar_usd,
    total_pagar_bs: 0,//props.pre_factura.total_pagar_bs,
    primer_pago: 0,//props.pre_factura.primer_pago,
    fecha_primer_pago:'',//props.pre_factura.fecha_primer_pago,
    segundo_pago: 0,//props.pre_factura.segundo_pago,
    fecha_segundo_pago:'',//props.pre_factura.fecha_segundo_pago,
    tercer_pago: 0,//props.pre_factura.tercer_pago,
    fecha_tercer_pago:'',//props.pre_factura.fecha_tercer_pago,
    total_pagos: 0,//props.pre_factura.total_pagos,
    saldos: 0,//props.pre_factura.saldos,
    anulado:'',//props.pre_factura.anulado,
    //datos comprobante_salida
    id_salida:props.comprobante_salida.id,
    fecha_salida:props.comprobante_salida.fecha_salida,
    empresa:props.comprobante_salida.empresa,
    responsable:props.comprobante_salida.responsable,
    camion:props.comprobante_salida.camion,
    placa:props.comprobante_salida.placa,
    licencia:props.comprobante_salida.licencia,
    celular:props.comprobante_salida.celular,
    contenedor:props.comprobante_salida.contenedor,
    presinto:props.comprobante_salida.presinto,
    reserva:props.comprobante_salida.reserva,
    factura:props.comprobante_salida.factura,
    destino:props.comprobante_salida.destino,
    codigo_salida:props.comprobante_salida.codigo_salida,
    pdf_comprobante_salida:props.comprobante_salida.pdf_comprobante_salida,
    liberacion:props.comprobante_salida.liberacion,
    //datos de solictud almacen
    id_solicitud:props.comprobante_salida.solicitud_carga.id,
    codigo:props.comprobante_salida.solicitud_carga.codigo,
    planta_id:props.comprobante_salida.solicitud_carga.planta_id,
    //cargas
    precio: 0,
    medida: '',
});

// Total acumulado
const totalFacturadoUSD = ref(0);
const totalFacturadoBS = ref(0);
const cargasDetails = ref([]);
// Función para calcular el total
const calculateTotal = (index) => {
    totalFacturadoUSD.value = 0;
    cargasDetails.value = [];

    props.comprobante_salida.solicitud_carga.cargas.forEach(car => {

        if (car.medida === 'KG') {
            totalFacturadoUSD.value += car.precio * car.kilosnetos;
        } else if (car.medida === 'LB') {
            totalFacturadoUSD.value += car.precio * car.librasnetas;
        }

        cargasDetails.value.push({
            id: car.id, // Asegúrate de que 'id' esté disponible en 'car'
            precio: car.precio,
            medida: car.medida
        });
    });

    totalFacturadoBS.value = totalFacturadoUSD.value * 6.96;
    calculateCommission();
};

const calculateCommission = () => {
    form.comision = (totalFacturadoUSD.value * form.comisionPorcentaje) / 100;
    form.total_pagar_usd = totalFacturadoUSD.value - form.comision;
    form.total_pagar_bs = form.total_pagar_usd * 6.86;
};

const calculateTotalPayments = () => {
    form.total_pagos = Number(form.primer_pago) + Number(form.segundo_pago) + Number(form.tercer_pago);
    calculateSaldo();
};

const calculateSaldo = () => {
    form.saldos = form.total_pagar_bs - form.total_pagos;
};

watch(() => props.comprobante_salida.solicitud_carga.cargas, calculateTotal, { deep: true });
watch(() => form.total_pagar_bs, calculateSaldo);

const submitForm = async () => {
    const data = {
        comprobante_salida: props.comprobante_salida.id,
        mes: form.mes,
        fecha_factura: form.fecha_factura,
        nro_factura: form.factura,
        razon_social: form.razon_social,
        nit: form.nit,
        incoterm: form.incoterm,
        lugar_destino: props.comprobante_salida.destino,
        puerto_destino: form.puerto_destino,
        direccion: form.direccion,
        tipo_cambio: 6.96,
        zafra:'2024',
        //carga
        cargasDetails: cargasDetails.value,
        //
        total_facturado_usd: totalFacturadoUSD.value,
        total_facturado_bs: totalFacturadoBS.value,
        comision: form.comision,
        total_pagar_usd: form.total_pagar_usd,
        total_pagar_bs: form.total_pagar_bs,
        //
        primer_pago: form.primer_pago,
        fecha_primer_pago: form.fecha_primer_pago,
        segundo_pago: form.segundo_pago,
        fecha_segundo_pago: form.fecha_segundo_pago,
        tercer_pago: form.tercer_pago,
        fecha_tercer_pago: form.fecha_tercer_pago,
        total_pagos: form.total_pagos,
        saldos: form.saldos,
        anulado: 0,
    };
    try {
        const response = await axios.post('/pre_factura/store', data);
        console.log(response);
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: response.data.message,
            willClose: () => {
                window.location.href = route('pre_factura.index');
            }
        });
    } catch (error) {
        if (error.response && error.response.status === 422) {
                // Manejo de errores de validación
                const errors = error.response.data.errors;
                for (const field in errors) {
                    // Aquí puedes manejar cada error como desees
                    console.error(`Error en ${field}: ${errors[field].join(', ')}`);
                    // Mostrar el error en el formulario
                    form.errors[field] = errors[field]; // Asegúrate de tener un objeto para errores
                }
                Swal.fire('Errores!', 'Por favor corrige los errores en el formulario.', 'error');
            } else {
                console.error('Error al guardar:', error);
                Swal.fire('Error!', 'Ocurrió un error al guardar los cambios.', 'error');
            }
    }
};
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
                <div class="mx-1">
                    <BlueButton :disabled="form.processing" @click.prevent="submitForm()">
                    <i class="fa-solid fa-save"></i> Guardar Pre Factura</BlueButton>
                </div>
            </div>
        </div>
            <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <div class="w-full whitespace-no-wrap">
                    <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                        <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">

                            <InputLabel value="Datos Pre Factura" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="MES" />
                                    <select v-model="form.mes" class="mt-2 block w-full">
                                        <option disabled value="">Seleccione un mes</option>
                                        <option value="ENERO">Enero</option>
                                        <option value="FEBRERO">Febrero</option>
                                        <option value="MARZO">Marzo</option>
                                        <option value="ABRIL">Abril</option>
                                        <option value="MAYO">Mayo</option>
                                        <option value="JUNIO">Junio</option>
                                        <option value="JULIO">Julio</option>
                                        <option value="AGOSTO">Agosto</option>
                                        <option value="SEPTIEMBRE">Septiembre</option>
                                        <option value="OCTUBRE">Octubre</option>
                                        <option value="NOVIEMBRE">Noviembre</option>
                                        <option value="DICIEMBRE">Diciembre</option>
                                    </select>
                                    <InputError :message="form.errors.mes" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="FECHA FACTURA"></InputLabel>
                                    <TextInput type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_factura" />
                                    <InputError :message="form.errors.fecha_factura" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="NRO. FACTURA"></InputLabel>
                                    <TextDisabled list="form.destino" type="text" class="mt-2 block w-full"
                                    v-model="form.factura" />
                                    <InputError :message="form.errors.factura" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="RAZON SOCIAL"/>
                                    <TextInput type="text" class="mt-2 block w-full"
                                    v-model="form.razon_social" />
                                    <InputError :message="form.errors.razon_social" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="NIT"/>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.nit" />
                                    <InputError :message="form.errors.nit" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="INCOTERM" />
                                    <select v-model="form.incoterm" class="mt-2 block w-full">
                                        <option disabled value="">Seleccione un Incoterm</option>
                                        <option value="CRF">CRF</option>
                                        <option value="FOB">FOB</option>
                                        <option value="RE">RE</option>
                                    </select>
                                    <InputError :message="form.errors.incoterm" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mt-4">
                                <div>
                                    <InputLabel value="LUGAR DE DESTINO"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.destino" />
                                    <InputError :message="form.errors.destino" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="PUERTO DESTINO"/>
                                    <TextInput type="text" class="mt-2 block w-full"
                                    v-model="form.puerto_destino" />
                                    <InputError :message="form.errors.puerto_destino" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="DIRECCION"/>
                                    <TextInput type="text" class="mt-2 block w-full"
                                    v-model="form.direccion" />
                                    <InputError :message="form.errors.direccion" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="ZAFRA"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.zafra" />
                                    <InputError :message="form.errors.zafra" class="mt-2"></InputError>
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
                                            PRECIO
                                        </th>
                                        <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                            UNIDAD MEDIDA
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(car, index) in props.comprobante_salida.solicitud_carga.cargas" :key="car.id">
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
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <TextInput type="number" class="mt-1 block"
                                                v-model="car.precio"
                                                @input="calculateTotal(index)"/>
                                                <InputError :message="form.errors.precio" class="mt-2"></InputError>
                                            </p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-3 py-3 text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                <select v-model="car.medida" class="mt-2 block w-full"
                                                @change="calculateTotal(index)">
                                                    <option disabled value="">Seleccione unidad medida</option>
                                                    <option value="KG">KG</option>
                                                    <option value="LB">LB</option>
                                                </select>
                                                <InputError :message="form.errors.medida" class="mt-2"></InputError>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <InputLabel value="Datos Monetarios" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-6 gap-4 mt-4">
                                <div>
                                    <InputLabel value="TOTAL FACTURADO USD"></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="totalFacturadoUSD" readonly />
                                    <InputError :message="form.errors.totalFacturadoUSD" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="TOTAL FACTURADO BS"/>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="totalFacturadoBS" readonly />
                                    <InputError :message="form.errors.totalFacturadoBS" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="COMISION %"/>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.comisionPorcentaje"
                                    @input="calculateCommission" />
                                    <InputError :message="form.errors.comisionPorcentaje" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="COMISION USD"/>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.comision" readonly/>
                                    <InputError :message="form.errors.comision" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="TOTAL PAGADO USD"></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.total_pagar_usd" readonly/>
                                    <InputError :message="form.errors.total_pagar_usd" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="TOTAL PAGADO BS"></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.total_pagar_bs" readonly/>
                                    <InputError :message="form.errors.total_pagar_bs" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <InputLabel value="Datos Pagos" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-6 gap-4 mt-4">
                                <div>
                                    <InputLabel value="PRIMER PAGO BS."></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.primer_pago"
                                    @input="calculateTotalPayments"/>
                                    <InputError :message="form.errors.primer_pago" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="FECHA PRIMER PAGO"/>
                                    <TextInput type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_primer_pago" />
                                    <InputError :message="form.errors.fecha_primer_pago" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="SEGUNDO PAGO BS."/>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.segundo_pago"
                                    @input="calculateTotalPayments"/>
                                    <InputError :message="form.errors.segundo_pago" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="FECHA SEGUNDO PAGO"></InputLabel>
                                    <TextInput type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_segundo_pago" />
                                    <InputError :message="form.errors.fecha_segundo_pago" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="TERCER PAGO BS."></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.tercer_pago"
                                    @input="calculateTotalPayments"/>
                                    <InputError :message="form.errors.tercer_pago" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="FECHA TERCER PAGO"></InputLabel>
                                    <TextInput type="date" class="mt-2 block w-full"
                                    v-model="form.fecha_tercer_pago" />
                                    <InputError :message="form.errors.fecha_tercer_pago" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="TOTAL PAGO BS."></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.total_pagos" readonly/>
                                    <InputError :message="form.errors.total_pagos" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="SALDO BS."/>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.saldos" readonly/>
                                    <InputError :message="form.errors.saldos" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="ANULADO"/>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    :value="form.anulado === 1 ? 'Sí' : 'No'"  disabled/>
                                    <InputError :message="form.errors.anulado" class="mt-2"></InputError>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>
