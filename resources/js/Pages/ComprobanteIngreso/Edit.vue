<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GreenButton from '@/Components/GreenButton.vue';
import CargaPlanta from '@/Components/CargaPlanta.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import FormConocimiento from '@/Components/FormConocimiento.vue';
import ComprobanteIngreso from '@/Components/ComprobanteIngreso.vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    comprobateIngreso: { type: Object },
    conocimiento: { type: Object },
    cargas: { type: Object },
    solicitud:{ type: Object },
});

const form = useForm({
    planta_id:props.solicitud.plantas_id,
    empresa:props.conocimiento.empresa,
    codigo_conocimiento:props.conocimiento.codigo,
    id_ingreso:props.comprobateIngreso.id,
    status:'',
    cargas:props.cargas,

});

const submitForm = (status) => {
    form.status = status;

    // Usar Axios para enviar la solicitud POST
    axios.post(route('kardexs.store'), form)
        .then(response => {
            // Suponiendo que la respuesta indica éxito
            Swal.fire({
                title: 'Éxito!',
                text: 'Kardex guardado exitosamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Opcional: redirigir o realizar otra acción después de cerrar el Swal
                window.location.href = route('kardexs.index'); // Cambia esto según sea necesario
            });
        })
        .catch(error => {
            // Manejo de error
            console.error('Error al guardar kardex:', error);
            let errorMessage = 'Ocurrió un error al guardar el kardex.';
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        });
};


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
  formData.append('comprobante_id', props.comprobateIngreso.id); // Cambiado a conocimiento_id

  processing.value = true;

  try {
    const response = await axios.post('/comprobante_ingreso/upload', formData, {
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
  return `${window.location.origin}/storage/comprobante_ingreso/${file}`;
};
</script>

<template>
    <Head title="Comprobante de Ingreso" />
    <AuthenticatedLayout>
        <template #header>
            Ver Comprobante de Ingreso
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('comprobante_ingreso.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1" v-if="props.comprobateIngreso.estado === 0">
                    <GreenButton @click.prevent="submitForm(1)">
                    <i class="fa-solid fa-circle-check fa-lg" style="color: #ffffff;"></i> Realizar Ingreso Almacen </GreenButton>
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <ComprobanteIngreso :comprobateIngreso = "comprobateIngreso"/>
                        <br>
                        <FormConocimiento :conocimiento="conocimiento" :solicitud="solicitud" />
                        <br>
                        <CargaPlanta :cargas="cargas"/>
                        <br>
                        <div v-if="props.comprobateIngreso.estado === 1">
                            <InputLabel value="Subir Comprobante Ingreso Firmado" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <br>
                            <div v-if="props.comprobateIngreso.pdf_comprobante_ingreso" class="preview-container">
                                <!-- Div izquierdo -->
                                <div class="uploaded-file-info">
                                    <h2>Archivo Subido:</h2>
                                    <p>Nombre del archivo: {{ props.comprobateIngreso.pdf_comprobante_ingreso }}</p>
                                    <a :href="getFileUrl(props.comprobateIngreso.pdf_comprobante_ingreso)" target="_blank">Ver PDF</a>
                                </div>
                                <!-- Div derecho para la vista previa -->
                                <div class="pdf-preview">
                                    <h1>Vista Previa:</h1>
                                    <iframe :src="getFileUrl(props.comprobateIngreso.pdf_comprobante_ingreso)" class="pdf-iframe" frameborder="0"></iframe>
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
