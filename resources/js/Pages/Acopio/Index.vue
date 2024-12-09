<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import GreenButton from '@/Components/GreenButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import Modal from '@/Components/Modal.vue';
import { computed } from 'vue';

const props = defineProps({
    kardexRiberalta: { type: Object },
    kardexSena: { type: Object },
    kardexCobija: { type: Object },
});


const costosLogisticos = ref([
    { nombre: 'Costos Exportación', monto_caja: 44.2, monto_kg: 2.21, monto_lb: 4.862},
    { nombre: 'Costos Comerciales', monto_caja: 0.04, monto_kg: 0.02, monto_lb: 0.044},
]);

const modal = ref(false);
const openModal = () => { modal.value = true; };
const closeModal = () => { modal.value = false; }
const agregarFila = () => { costosLogisticos.value.push({ nombre: '', monto: 0 }); };
const eliminarFila = (index) => { costosLogisticos.value.splice(index, 1); };

const totalMontoCaja = computed(() => {
    return costosLogisticos.value.reduce((total, costo) => total + parseFloat(costo.monto_caja || 0), 0);
});

const totalMontoKg = computed(() => {
    return costosLogisticos.value.reduce((total, costo) => total + parseFloat(costo.monto_kg || 0), 0);
});

const totalMontoLb = computed(() => {
    return costosLogisticos.value.reduce((total, costo) => total + parseFloat(costo.monto_lb || 0), 0);
});
//
const totalProLogCaja = computed(() => {
    return parseFloat(totalMontoCaja.value) + parseFloat(costoCaja.value);
});

const totalProLogKg = computed(() => {
    return parseFloat(totalMontoKg.value) + parseFloat(costoKg.value);
});

const totalProLogLb = computed(() => {
    return parseFloat(totalMontoLb.value) + parseFloat(costoLb.value);
});

// Cálculo de utilidad basado en el porcentaje
const porcentaje = ref(0);

const utilidadCaja = computed(() => {
  const total = totalProLogCaja.value;
  return (total * (porcentaje.value / 100));
});
const utilidadKg = computed(() => {
  const total = totalProLogKg.value;
  return (total * (porcentaje.value / 100));
});
const utilidadLb = computed(() => {
  const total = totalProLogLb.value;
  return (total * (porcentaje.value / 100));
});
//calcula el precio final
const precioFinalCaja = computed(() => {
    const total = totalProLogCaja.value + utilidadCaja.value;
    return parseFloat(total.toFixed(2));
});
const precioFinalKg = computed(() => {
    const total = totalProLogKg.value + utilidadKg.value;
    return parseFloat(total.toFixed(2));
});
const precioFinalLb = computed(() => {
    const total = totalProLogLb.value + utilidadLb.value;
    return parseFloat(total.toFixed(2));
});
//calcula precio final dolares
const precioDolar = 6.96;
const precioFinalCajaDolar = computed(() => {
    const total = precioFinalCaja.value / precioDolar;
    return parseFloat(total.toFixed(2));
});
const precioFinalKgDolar = computed(() => {
    const total = precioFinalKg.value / precioDolar;
    return parseFloat(total.toFixed(2));
});
const precioFinalLbDolar = computed(() => {
    const total = precioFinalLb.value / precioDolar;
    return parseFloat(total.toFixed(2));
});
//logica
const costoCaja = ref(0);
const costoKg = ref(0);
const costoLb = ref(0);

const handleClick = (monto) => {
  costoCaja.value = Number(monto);
  costoKg.value = costoCaja.value / 20;
  costoLb.value = costoKg.value / 2.2;
  console.log(`Costo Caja: ${costoCaja.value}, Costo Kg: ${costoKg.value}, Costo Lb: ${costoLb.value}`);
};

const costoAcopio = ref([
  { id: 1, value: 250, monto: 785.59 },
  { id: 2, value: 260, monto: 795.59 },
  { id: 3, value: 270, monto: 805.59 },
  { id: 4, value: 280, monto: 815.59 },
  { id: 5, value: 290, monto: 825.59 },
  { id: 6, value: 300, monto: 835.59 },
  { id: 7, value: 310, monto: 837.92 },
  { id: 8, value: 320, monto: 847.92 },
  { id: 9, value: 330, monto: 837.92 },
  { id: 10, value: 340, monto: 867.92 },
  { id: 11, value: 350, monto: 877.92 },
  { id: 12, value: 360, monto: 887.92 },
]);
</script>
<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            Acopio
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-4 flex">
                <div v-for="item in kardexRiberalta" :key="item.id" class="mr-2">
                    <GreenButton @click="handleClick(item.costo_caja)"
                        class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                        Lote {{ item.lote }} - Bs.{{ item.costo_caja }}
                    </GreenButton>
                </div>
            </div>
        </div>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div v-for="item in kardexSena" :key="item.id" class="mr-2">
                    <GreenButton @click="handleClick(item.costo_caja)"
                        class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                        Lote {{ item.lote }} - Bs.{{ item.costo_caja }}
                    </GreenButton>
                    </div>
            </div>
        </div>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div v-for="item in kardexCobija" :key="item.id" class="mr-2">
                    <GreenButton @click="handleClick(item.costo_caja)"
                        class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                        Lote {{ item.lote }} - Bs.{{ item.costo_caja }}
                    </GreenButton>
                    </div>
            </div>
        </div>
        <div class="mb-4 w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex flex-wrap justify-between">
                <div v-for="item in costoAcopio" :key="item.id" class="mr-2 mb-2">
                    <GreenButton @click="handleClick(item.monto)"
                        class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                        {{ item.value }}
                    </GreenButton>
                </div>
            </div>
        </div>
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Costos
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Precio Caja
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Precio Kg.
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Precio Lb.
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Porcentaje
                            </th>
                            <th class="border-b-2 border-gray-200 bg-gray-100 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">Bruto de Producción</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                {{ (costoCaja).toFixed(2) }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                {{ (costoKg).toFixed(2) }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                {{ (costoLb).toFixed(2) }}
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap"> </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap"> </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">Logistico FOB</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (totalMontoCaja).toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (totalMontoKg).toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">{{ (totalMontoLb).toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap"> </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <GreenButton @click="$event=>openModal()">
                                        <i class="fa-solid fa-coins fa-xs" style="color: #ffffff;"></i>
                                    </GreenButton>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-red-500 whitespace-no-wrap">Costo Total FOB</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-red-500 whitespace-no-wrap">{{ (totalProLogCaja).toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-red-500 whitespace-no-wrap">{{ (totalProLogKg).toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-red-500 whitespace-no-wrap">{{ (totalProLogLb).toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-red-500 whitespace-no-wrap"> </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-red-500 whitespace-no-wrap"> </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">Utilidad</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">{{ utilidadCaja.toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">{{ utilidadKg.toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap">{{ utilidadLb.toFixed(2) }}</p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">

                                    <TextInput type="number" v-model="porcentaje" class="w-6 h-6"></TextInput>

                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-900 whitespace-no-wrap"> </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>Final de Venta Bs.</strong>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>
                                        {{ precioFinalCaja.toFixed(2) }}
                                    </strong>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>
                                        {{ precioFinalKg.toFixed(2) }}
                                    </strong>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>
                                        {{ precioFinalLb.toFixed(2) }}
                                    </strong>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text"></td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-500 whitespace-no-wrap"> </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-b border-green-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>Final de Venta $</strong>
                                </p>
                            </td>
                            <td class="border-b border-green-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>{{ precioFinalCajaDolar.toFixed(2) }}</strong>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>{{ precioFinalKgDolar.toFixed(2) }}</strong>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-green-500 whitespace-no-wrap">
                                    <strong>{{ precioFinalLbDolar.toFixed(2) }}</strong>
                                </p>
                            </td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text"></td>
                            <td class="border-b border-gray-200 bg-white px-3 py-3 text">
                                <p class="text-gray-500 whitespace-no-wrap"> </p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
                    <Modal :show="modal" @close="closeModal">
                        <div class="min-w-full overflow-x-auto rounded-lg shadow">
                            <h2 class="p-3 text-lg font-medium text-gray-900">Detalle de Costos Logisticos</h2>
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 p-2">Nombre Costo</th>
                                        <th class="border border-gray-300 p-2">Costo Caja (Bs.)</th>
                                        <th class="border border-gray-300 p-2">Costo Kg (Bs.)</th>
                                        <th class="border border-gray-300 p-2">Costo Lb (Bs.)</th>
                                        <th class="border border-gray-300 p-2">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(costo, index) in costosLogisticos" :key="index">
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <TextInput type="text" v-model="costo.nombre" class="w-6 h-6"/>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <TextInput type="number" v-model="costo.monto_caja" class="w-6 h-6"
                                            />
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <TextInput type="number" v-model="costo.monto_kg" class="w-6 h-6"
                                            />
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <TextInput type="number" v-model="costo.monto_lb" class="w-6 h-6"
                                            />
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <GreenButton v-if="index === costosLogisticos.length - 1" @click="agregarFila">
                                                <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i>
                                            </GreenButton>
                                            <WarningButton v-if="index <  costosLogisticos.length - 1" @click="eliminarFila(index)">
                                                <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                                            </WarningButton>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1"> Total:</td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <p class="text-gray-500 whitespace-no-wrap">
                                                {{ totalMontoCaja.toFixed(2) }}
                                            </p>

                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <p class="text-gray-500 whitespace-no-wrap">
                                                {{ totalMontoKg.toFixed(2) }}
                                            </p>
                                        </td>
                                        <td class="border-b border-gray-200 bg-white px-2 py-2 text w-1">
                                            <p class="text-gray-500 whitespace-no-wrap">
                                                {{ totalMontoLb.toFixed(2) }}
                                            </p>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </Modal>
    </AuthenticatedLayout>
</template>
