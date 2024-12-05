<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import CargaAlmacen from '@/Components/CargaAlmacen.vue';
import GreenButton from '@/Components/GreenButton.vue';

const props = defineProps({
    comprobanteSalida: { type: Object },
    cargas: { type: Array},

});

const form = useForm({
    //datos de comprobante de salida
    fecha_salida: props.comprobanteSalida.fecha_salida,
    empresa: props.comprobanteSalida.empresa,
    responsable: props.comprobanteSalida.responsable,
    camion:props.comprobanteSalida.camion,
    placa:props.comprobanteSalida.placa,
    licencia:props.comprobanteSalida.licencia,
    celular:props.comprobanteSalida.celular,
    contenedor:props.comprobanteSalida.contenedor,
    presinto:props.comprobanteSalida.presinto,
    reserva:props.comprobanteSalida.reserva,
    factura:props.comprobanteSalida.factura,
    destino:props.comprobanteSalida.destino,
    codigo_salida:props.comprobanteSalida.codigo_salida,
    //datos de detallesalida
});

//srcipt para la subida del PDF
const processing = ref(false);
const selectedFile = ref(null);
const filePath = ref('');
const fileName = ref('');

const handleFileUpload = (event) => {
  selectedFile.value = event.target.files[0];
};

const handleSubmit = async () => {
    if (!selectedFile.value) return;

  const formData = new FormData();
  formData.append('file', selectedFile.value);
  formData.append('comprobante_id', props.comprobanteSalida.id); // Cambiado a conocimiento_id

  console.log([...formData]);
  processing.value = true;

  try {
    const response = await axios.post('/comprobante_salida/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    filePath.value = response.data.path;
    fileName.value = response.data.file_name;

    // Genera la URL para acceder al archivo
    const fileUrl = getFileUrl(fileName.value);
    console.log(fileUrl); // Muestra la URL generada en la consola

  } catch (error) {
    console.error('Error al subir el archivo:', error);
  } finally {
    location.reload();
    processing.value = false;
  }
};

const getFileUrl = (file) => {
  return `${window.location.origin}/storage/comprobante_salida/${file}`;
};
</script>

<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            Ver Comprobante de Salida
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('comprobante_salida.index')"
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
                    <InputLabel value="Datos de Comprobante de Ingreso" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                        <div class="grid grid-cols-4 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Fecha de Salida"/>
                                    <TextDisabled type="text" class="mt-2 block w-full" v-model="form.fecha_salida" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="Codigo de Salida"/>
                                    <TextDisabled type="text" class="mt-2 block w-full" v-model="form.codigo_salida" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="Nro. Factura"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.factura" disabled/>
                                </div>
                                <div>
                                    <InputLabel value="Destino"></InputLabel>
                                    <TextDisabled list="form.destino" type="text" class="mt-2 block w-full"
                                    v-model="form.destino" disabled></TextDisabled>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Nro. Contenedor"></InputLabel>
                                    <TextDisabled list="form.contenedor" type="text" class="mt-2 block w-full"
                                    v-model="form.contenedor" autofocus disabled></TextDisabled>
                                </div>
                                <div>
                                    <InputLabel value="Nro. Presinto"></InputLabel>
                                    <TextDisabled list="form.presinto" type="text" class="mt-2 block w-full"
                                    v-model="form.presinto" autofocus disabled></TextDisabled>

                                </div>
                                <div>
                                    <InputLabel value="Nro. Reserva"></InputLabel>
                                    <TextDisabled list="form.reserva" type="text" class="mt-2 block w-full"
                                    v-model="form.reserva" autofocus disabled></TextDisabled>

                                </div>
                            </div>
                            <br>
                            <InputLabel value="Datos de Empresa" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel for="empresa" value="Empresa Transportista"/>
                                    <TextDisabled list="form.empresa" type="text" class="mt-2 block w-full" v-model="form.empresa"
                                    placeholder="Ej. Trans Huayana Kapac SRL." disabled/>
                                </div>
                                <div>
                                    <InputLabel for="conductor" value="Conductor"></InputLabel>
                                    <TextDisabled list="form.responsable" type="text" class="mt-2 block w-full"
                                    v-model="form.responsable" disabled ></TextDisabled>

                                </div>
                                <div>
                                    <InputLabel for="vehiculo" value="Vehiculo"></InputLabel>
                                    <TextDisabled list="form.camion" type="text" class="mt-2 block w-full"
                                    v-model="form.camion" disabled ></TextDisabled>

                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel for="licencia" value="Licencia"></InputLabel>
                                    <TextDisabled list="form.licencia" type="text" class="mt-2 block w-full"
                                    v-model="form.licencia" autofocus disabled ></TextDisabled>
                                </div>
                                <div>
                                    <InputLabel for="placa" value="Placa"></InputLabel>
                                    <TextDisabled list="form.placa" type="text" class="mt-2 block w-full"
                                    v-model="form.placa" autofocus disabled ></TextDisabled>

                                </div>
                                <div>
                                    <InputLabel for="celular" value="Celular"></InputLabel>
                                    <TextDisabled list="form.celular" type="number" class="mt-2 block w-full"
                                    v-model="form.celular" autofocus disabled></TextDisabled>
                                </div>
                            </div>
                            <br>
                            <CargaAlmacen :cargas = "cargas" />
                            <br>
                    <div>
                        <InputLabel value="Subir Comprobante de Salida Firmado" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                        <br>
                        <div v-if="props.comprobanteSalida.pdf_comprobante_salida" class="preview-container">
                            <!-- Div izquierdo -->
                            <div class="uploaded-file-info">
                                <h2>Archivo Subido:</h2>
                                <p>Nombre del archivo: {{ props.comprobanteSalida.pdf_comprobante_salida }}</p>
                                <a :href="getFileUrl(props.comprobanteSalida.pdf_comprobante_salida)" target="_blank">Ver PDF</a>
                            </div>

                            <!-- Div derecho para la vista previa -->
                            <div class="pdf-preview">
                                <h2>Vista Previa:</h2>
                                <iframe :src="getFileUrl(props.comprobanteSalida.pdf_comprobante_salida)" class="pdf-iframe" frameborder="0"></iframe>
                            </div>
                        </div>

                        <div v-else>
                            <h2>Subir PDF</h2>
                            <form @submit.prevent="handleSubmit">
                                <input type="file" @change="handleFileUpload" accept=".pdf" required />
                                <GreenButton type="submit" :disabled="processing">Subir</GreenButton>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.preview-container {
    display: flex; /* Usar flexbox para alinear los elementos */
    align-items: flex-start; /* Alinear al inicio */
}

.uploaded-file-info {
    flex: 1; /* Ocupa el espacio restante */
    margin-right: 20px; /* Espacio entre los divs */
}

.pdf-preview {
    flex: 1; /* Ocupa el espacio restante */
}

.pdf-iframe {
    width: 100%; /* Ancho completo del contenedor */
    height: 600px; /* Ajusta la altura según lo desees */
    border: none; /* Sin borde */
}
</style>
