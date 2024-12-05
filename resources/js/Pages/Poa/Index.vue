<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, reactive, computed  } from 'vue';
import { Head } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import GreenButton from '@/Components/GreenButton.vue';
import Modal from '@/Components/Modal.vue';
import { Bar, Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, PointElement, LineElement  } from 'chart.js'
import axios from 'axios';
import Swal from 'sweetalert2';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, PointElement, LineElement)

const props = defineProps({
    poa: {
        type: Object,
    },
    estadistica: {
        type:Array,
    }
});
//estaditica
const chartData = ref({
  labels: [],
  datasets: [],
});

const chartOptions = reactive({
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
  },
});

const metaMensualVolumen = computed(() => {
    if (props.poa && props.poa.meta_volumen != null) {
        return props.poa.meta_volumen / 12;
    }
    return 0;
});

const metaMensualMonetario = computed(() => {
    if (props.poa && props.poa.meta_monetaria != null) {
        return props.poa.meta_monetaria / 12;
    }
    return 0;
});
const valuesMetaVolumen = Array(12).fill(metaMensualVolumen.value);
const valuesMetaMonetario = Array(12).fill(metaMensualMonetario.value);
const valuesAlcanzada = Array(12).fill(0);

const mesMap = {
    'ENERO': 0,
    'FEBRERO': 1,
    'MARZO': 2,
    'ABRIL': 3,
    'MAYO': 4,
    'JUNIO': 5,
    'JULIO': 6,
    'AGOSTO': 7,
    'SEPTIEMBRE': 8,
    'OCTUBRE': 9,
    'NOVIEMBRE': 10,
    'DICIEMBRE': 11
};

props.estadistica.forEach(est => {
    const mesIndex = mesMap[est.mes.toUpperCase()];
    if (mesIndex !== undefined) {
        valuesAlcanzada[mesIndex] = est.total;
    }
});


 chartData.value = ({
    labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    datasets: [
        {
            label: 'Meta Mensual',
            data: valuesMetaVolumen,
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
        },
        {
            label: 'Meta Alcanzada',
            data: valuesAlcanzada,
            backgroundColor: 'rgba(200, 192, 192, 0.5)',
        },
    ],
});
//modal
const modal = ref(false);

const openModal = () => {
    modal.value = true
    axios.get(route('poa.edit'))
        .then(response => {
            console.log(response.data);
            form.value.meta_volumen = response.data.meta_volumen;
            form.value.meta_monetaria = response.data.meta_monetaria;
        })
        .catch(error => {
            console.error("Error al cargar los datos: ", error);
        });

};
const closeModal = () => { modal.value = false };
//introducion de datos
const form = ref({
    meta_gestion: new Date().getFullYear(),
    meta_volumen: '',
    meta_monetaria: '',
});
//save
const savePoa = () => {
    axios.post(route('poa.store'), {
        meta_gestion: form.value.meta_gestion,
        meta_volumen: form.value.meta_volumen,
        meta_monetaria: form.value.meta_monetaria,
    })
    .then(response => {
        console.log(response);
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'Datos guardados exitosamente.',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            closeModal();
            window.location.reload();
        });
    })
    .catch(error => {
        console.error(error);
        let errorMessage = 'Ocurrió un error al guardar los datos.';

        if (error.response) {
            if (error.response.status === 422) {
                errorMessage = 'Por favor corrige los siguientes errores:\n';
                const errors = error.response.data.errors;
                for (const [key, messages] of Object.entries(errors)) {
                    errorMessage += `${messages.join(', ')}\n`;
                }
            }
        } else if (error.request) {
            errorMessage = 'No se recibió respuesta del servidor.';
        } else {
            errorMessage = 'Error al intentar guardar los datos: ' + error.message;
        }

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
            confirmButtonText: 'Aceptar'
        });
    });
};

</script>
<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            POA
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mr-2">
                    <GreenButton @click="openModal()"
                    class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                    <i class="fa-solid fa-chart-simple" style="color: #ffffff;"></i> Metas del POA
                    </GreenButton>
                </div>
            </div>
        </div>
        <div class="min-w-full overflow-x-auto rounded-lg bg-white shadow">
            <div class="grid grid-cols-2 gap-4 p-4">
                <div class="border rounded-lg bg-white shadow">
                    <Bar :data="chartData" :options="chartOptions" ref="chartRef" />
                </div>
                <div class="border rounded-lg bg-white shadow">
                    <Line :data="chartData" :options="chartOptions" ref="chartRef" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 p-4">
                <div class="border rounded-lg bg-white shadow">
                    <Bar :data="chartData" :options="chartOptions" ref="chartRef" />
                </div>
                <div class="border rounded-lg bg-white shadow">
                    <Line :data="chartData" :options="chartOptions" ref="chartRef" />
                </div>
            </div>
        </div>

    <Modal :show="modal" @close="closeModal">
        <div class="min-w-md overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <h2 class="p-3 text-lg font-medium text-gray-900">Metas y Costos Anuales</h2>
                        <form @submit.prevent="savePoa">
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <InputLabel value="Gestion"></InputLabel>
                                </div>
                                <div>
                                    <TextDisabled v-model="form.meta_gestion" type="number" class="mt-2 block w-full"></TextDisabled>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <InputLabel value="Meta Anual de Volumen"></InputLabel>
                                </div>
                                <div>
                                    <TextInput v-model="form.meta_volumen" type="number" class="mt-2 block w-full"></TextInput>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-1 mt-1">
                                <div>
                                    <InputLabel value="Meta Anual Monetaria"></InputLabel>
                                </div>
                                <div>
                                    <TextInput v-model="form.meta_monetaria" type="number" class="mt-2 block w-full"></TextInput>
                                </div>
                            </div>
                                <GreenButton type="submit"
                                class="inline-block rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-500 text-sm">
                                <i class="fa-solid fa-save" style="color: #ffffff;"></i> Guardar y salir
                                </GreenButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
    </AuthenticatedLayout>
</template>
