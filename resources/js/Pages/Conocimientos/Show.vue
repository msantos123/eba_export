<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import CargaPlanta from '@/Components/CargaPlanta.vue';
import Conocimientos from '@/Components/Conocimientos.vue';
import GreenButton from '@/Components/GreenButton.vue';
import { ref, defineProps } from 'vue';
import axios from 'axios';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    conocimientos: { type: Object },
    solicitudcarga: { type:Object },
    cargas: { type: Object },
    salidaDetalle: { type: Object },
})

const form = useForm({
    id: props.conocimientos.id,
})

const CreateIngreso = (conocimientos) => {
    form.get(route('comprobante_ingreso.createAlmacen',conocimientos), {
    });
}

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
  formData.append('conocimiento_id', props.conocimientos.id); // Cambiado a conocimiento_id

  processing.value = true;

  try {
    const response = await axios.post('/conocimientos/upload', formData, {
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
  return `${window.location.origin}/storage/conocimientos/${file}`;
};
</script>

<template>
    <Head title="Editar Conocimiento" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <AuthenticatedLayout>
        <template #header>
            Ver Conocimiento de Carga
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('conocimientos.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <GreenButton @click.prevent="CreateIngreso(conocimientos) "
                    v-if ="$page.props.user.permissions.includes('Crear Comprobante Ingreso') && props.conocimientos.estado === 1">
                    <i class="fa-solid fa-circle-check fa-lg" style="color: #ffffff;"></i> Realizar Comprobante de Ingreso </GreenButton>
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <Conocimientos :conocimientos = "conocimientos" />
                    <br>
                    <CargaPlanta :cargas = "cargas"/>
                    <br>
                    <div v-if="props.conocimientos.estado === 1 || props.conocimientos.estado === 2">
                        <InputLabel value="Subir Conocimiento Firmado" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                        <br>
                        <div v-if="props.conocimientos.pdf_conocimiento" class="preview-container">
                            <!-- Div izquierdo -->
                            <div class="uploaded-file-info">
                                <h2>Archivo Subido:</h2>
                                <p>Nombre del archivo: {{ props.conocimientos.pdf_conocimiento }}</p>
                                <a :href="getFileUrl(props.conocimientos.pdf_conocimiento)" target="_blank">Ver PDF</a>
                            </div>

                            <!-- Div derecho para la vista previa -->
                            <div class="pdf-preview">
                                <h2>Vista Previa:</h2>
                                <iframe :src="getFileUrl(props.conocimientos.pdf_conocimiento)" class="pdf-iframe" frameborder="0"></iframe>
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
