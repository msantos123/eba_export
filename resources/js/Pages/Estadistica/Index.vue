<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { reactive, ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import GreenButton from '@/Components/GreenButton.vue';
import { Bar, Doughnut, Pie, Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, PointElement, LineElement  } from 'chart.js'
import axios from 'axios';
import * as XLSX from 'xlsx';
import BlueButton from '@/Components/BlueButton.vue';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, PointElement, LineElement)
// Declaración de variables reactivas
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
const errorMessage = ref('');
const validateAndFetchChartData = () => {
    if (!selectedCategory.value || !selectedField.value || !selectedOperacion.value) {
        errorMessage.value = 'Por favor, selecciona una opción de cada categoría.';
    } else {
        errorMessage.value = '';
        fetchChartData();
    }
};
// Función para obtener datos del gráfico
const fetchChartData = async () => {
  try {
    const response = await axios.get('/estadistica/sumatoria', {
      params: {
        categories: selectedCategory.value,
        field: selectedField.value,
        operacion: selectedOperacion.value,
      },
    });
    data.value = Array.isArray(response.data) ? response.data : [response.data];
    updateChartData(data.value);
  } catch (error) {
    console.error("Error fetching data:", error);
  }
};
const data = ref(null);
const exportToExcel = () => {
  if (!data.value || !Array.isArray(data.value)) {
    console.error("No hay datos válidos para exportar:", data.value);
    errorMessage.value = 'No hay datos válidos para exportar.';
    return;
  }

  const worksheet = XLSX.utils.json_to_sheet(data.value);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Datos');
  XLSX.writeFile(workbook, 'datos_exportados.xlsx');
};

const updateChartData = (data) => {
  if (!Array.isArray(data)) {
    console.error("La respuesta no es un array:", data);
    return;
  }

  const labels = data.map(item => item.etiqueta);
  const values = data.map(item => item.total);
  const colors = values.map(() => `rgb(${random()}, ${random()}, ${random()})`);

  chartData.value = {
    labels,
    datasets: [{
      data: values,
      backgroundColor: colors,
    }],
  };
};

const random = () => Math.floor(Math.random() * 256);

onMounted(() => {
  fetchChartData();
});

const props = defineProps({
    datos: {type: Boolean},
    fechaDatos: {type: String},
});


const uploadFile = async () => {
  const formData = new FormData();
  formData.append('file', file.value);

  try {
    const response = await axios.post('/estadistica/update_excel', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    message.value = response.data.message;
  } catch (error) {
    console.error(error);
    message.value = 'Error uploading file';
  }
};

const selectCategory = (category) => {
  selectedCategory.value = category; // Cambiar a un solo valor
};
const selectField = (field) => {
  selectedField.value = field;
};
const selectOperacion = (ope) => {
  selectedOperacion.value = ope;
};

const selectedCategory = ref(null);
const categoryOptions = [
    { value: 'mes', label: 'Mes' },
    { value: 'fecha_factura', label: 'Fecha de Factura' },
    { value: 'razon_social', label: 'Razon Social' },
    { value: 'incoterm', label: 'Incoterm' },
    { value: 'lugar_destino', label: 'Lugar Destino' },
    { value: 'puerto_destino', label: 'Puerto Destino' },
    { value: 'zafra', label: 'Zafra' },
];

const selectedField = ref(null);
const fieldOptions = [
  { value: 'total_facturado_usd', label: 'Total Facturado USD' },
  { value: 'total_facturado_bs', label: 'Total Facturado Bs.' },
  { value: 'comision', label: 'Comision' },
  { value: 'total_pagar_usd', label: 'Total Pagar USD' },
  { value: 'total_pagar_bs', label: 'Total Pagar Bs.' },
  { value: 'primer_pago', label: 'Primer Pago' },
  { value: 'segundo_pago', label: 'Segundo Pago' },
  { value: 'tercer_pago', label: 'Tercer Pago' },
  { value: 'total_pagos', label: 'Total Pagos' },
  { value: 'saldos', label: 'Saldos' }
];

const selectedOperacion = ref(null);
const operacionOptions = [
  { value: 'SUM', label: 'Suma' },
  { value: 'AVG', label: 'Promedio' },
  { value: 'COUNT', label: 'Contar' },
  { value: 'MAX', label: 'Maximos' },
  { value: 'MIN', label: 'Minimos' },
];
</script>
<style scoped>
button {
  padding: 10px 15px;
  margin: 5px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button.active {
  background-color: #007BFF; /* Color cuando el botón está activo */
  color: white;
}

button.inactive {
  background-color: #f0f0f0; /* Color cuando el botón no está activo */
  color: #333;
}
</style>
<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            Estadisticas
        </template>
        <!--<div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div>
                    <input type="file" @change="onFileChange" />
                    <GreenButton @click="uploadFile">Subir Excel</GreenButton>
                    <p v-if="message">{{ message }}</p>
                </div>
            </div>
        </div>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
            <div>
                <p class="text-green-600" v-if="props.datos==true"><strong>Datos cargados.</strong> </p>
                <p class="text-red-600" v-else="datos==false"><strong>Sin Datos.</strong> se tiene datos cargados.</p>
                <p class="text-green-600" v-if="props.fechaDatos"><strong> Ultima Actualización: {{ (fechaDatos) }}</strong></p>
            </div>
            </div>
        </div>-->

        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <div class="button-group">
                            <h2>Categorías</h2>
                            <GreenButton
                                v-for="(category, index) in categoryOptions"
                                :key="index"
                                :class="{ active: selectedCategory === category.value, inactive: selectedCategory !== category.value }"
                                @click="selectCategory(category.value)">
                                {{ category.label }}
                            </GreenButton>
                        </div>
                        <div class="button-group">
                            <h2>Datos</h2>
                            <GreenButton
                                v-for="(field, index) in fieldOptions"
                                :key="index"
                                :class="{ active: selectedField === field.value, inactive: selectedField !== field.value }"
                                @click="selectField(field.value)">
                                {{ field.label }}
                            </GreenButton>
                        </div>
                        <div class="button-group">
                            <h2>Operación</h2>
                            <GreenButton
                                v-for="(ope, index) in operacionOptions"
                                :key="index"
                                :class="{ active: selectedOperacion === ope.value, inactive: selectedOperacion !== ope.value }"
                                @click="selectOperacion(ope.value)">
                                {{ ope.label }}
                            </GreenButton>
                        </div>
                        <div class="button-group">
                            <GreenButton @click="validateAndFetchChartData">Generar Estadísticas</GreenButton>
                            <BlueButton @click="exportToExcel" :disabled="!data">Generar Excel</BlueButton>
                        </div>
                        <div v-if="errorMessage" class="error-message text-red-400 ">{{ errorMessage }}</div>
                    </div>
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
                    <Pie :data="chartData" :options="chartOptions" ref="chartRef" />
                </div>
                <div class="border rounded-lg bg-white shadow">
                    <Doughnut :data="chartData" :options="chartOptions" ref="chartRef" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
