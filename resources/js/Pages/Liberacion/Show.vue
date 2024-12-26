<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref, watch  } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import GreenButton from '@/Components/GreenButton.vue';
import axios from 'axios';
import TextDisabled from '@/Components/TextDisabled.vue';

const props = defineProps({
    liberacion: { type: Object },
});

const form = useForm({
    libe_nave_viaje: props.liberacion.libe_nave_viaje,
    libe_bl: props.liberacion.libe_bl,
    libe_puerto: props.liberacion.libe_puerto,
    libe_consignatario: props.liberacion.libe_consignatario,
    libe_direccion: props.liberacion.libe_direccion,
});

//guardarPDF
const documentos = ref([
  { label: "Contrato de Venta", nro: "", archivo: null, subido: false, placeholder: "Nro. Contrato", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Factura Comercial", nro: "", archivo: null, subido: false, placeholder: "Nro. Factura", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Lista de Empaque", nro: "", archivo: null, subido: false, placeholder: "Nro. Empaque", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "B/L Bill of Lading", nro: "", archivo: null, subido: false, placeholder: "SEA WAYBILL No.", tipos: ["CRF - FOB"]},
  { label: "Fitosanitario", nro: "", archivo: null, subido: false, placeholder: "Nro. Fitosanitario", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Inocuidad Alimentaria", nro: "", archivo: null, subido: false, placeholder: "Nro. Inocuidad Alimentaria", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Test Repost", nro: "", archivo: null, subido: false, placeholder: "Nro. Test Repost", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Certificado de Origen", nro: "", archivo: null, subido: false, placeholder: "Nro. Certificado de Origen", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "DEX", nro: "", archivo: null, subido: false, placeholder: "Nro. DEX", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Certificado de Salida ANB", nro: "", archivo: null, subido: false, placeholder: "Nro. Cert. de Salida ANB", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "MIC/DTA", nro: "", archivo: null, subido: false, placeholder: "Nro. MIC/DTA", tipos: ["CRF - FOB"]},
  { label: "CRT", nro: "", archivo: null, subido: false, placeholder: "Nro. CRT" , tipos: ["CRF - FOB"]},
  { label: "CFO", nro: "", archivo: null, subido: false, placeholder: "Nro. CFO", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Comprobante de Salida (Fotografias)", nro: "", archivo: null, subido: false, placeholder: "Nro. Comprobante de Salida", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "EIR Gate Out", nro: "", archivo: null, subido: false, placeholder: "Nro. de EIR Gate Out", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Carta de Envio de Documentos (Transportista)", nro: "", archivo: null, subido: false, placeholder: "Nro. Carta", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Carta de Envio de Documentos (Cliente)", nro: "", archivo: null, subido: false, placeholder: "Nro. Carta", tipos: ["CRF - FOB", "EXWORD"] },
  { label: "Otros Documentos", nro: "", archivo: null, subido: false, placeholder: "Descripcion Otros Documentos", tipos: ["CRF - FOB", "EXWORD"] },
]);
// Parsear los documentos
const parsedDocumentos = JSON.parse(props.liberacion.documentos);

// Asignar los números de documento y las rutas PDF
watch(() => props.lib, (newLib) => {
  const basePath = '/storage/liberaciones/'; // Asegúrate de que esta sea la ruta correcta para tus archivos
  parsedDocumentos.forEach((doc, index) => {
    if (index < documentos.value.length) {
      documentos.value[index].nro = doc.nro_documento;
      documentos.value[index].pdf = basePath + doc.pdf_documento; // Asigna la ruta del PDF al objeto
    }
  });
}, { immediate: true });

// Función para abrir el documento
const openDocument = (pdfUrl) => {
  window.open(pdfUrl, '_blank');
};

//srcipt para la subida del PDF
const processing = ref(false);
const selectedFile = ref(null);
const filePath = ref('');
const fileName = ref('');

const handleFileUpload = (event) => {
  selectedFile.value = event.target.files[0];
};

const handleSubmit = async (documentType) => {
    if (!selectedFile.value) return;

  const formData = new FormData();
  formData.append('file', selectedFile.value);
  formData.append('liberacion_id', props.liberacion.id);
  formData.append('document_type', documentType);

  processing.value = true;

  try {
    const response = await axios.post('/liberacion/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    filePath.value = response.data.path;
    fileName.value = response.data.file_name;

    const fileUrl = getFileUrl(fileName.value);

  } catch (error) {
    console.error('Error al subir el archivo:', error);
  } finally {
    location.reload();
    processing.value = false;
  }
};

const getFileUrl = (file) => {
  return `${window.location.origin}/storage/liberaciones/${file}`;
};
</script>
<style>
.editor {
  height: 200px;
}
.opacity-50 {
    opacity: 0.5;
}
</style>
<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            Documentos Digitales - Factura Nro. {{ props.liberacion.libe_factura }}
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('liberacion.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <Link v-if ="$page.props.user.permissions.includes('Revisar Liberacion') && props.liberacion.libe_estado === 0" :href="route('liberacion.aprobacion', { estado: 1, id: props.liberacion.id})"
                    class="inline-block rounded-md bg-green-500 px-4 py-2 text-white hover:bg-green-400 text-sm">
                    <i class="fa-solid fa-file-circle-check" style="color: #ffffff;"></i> Liberación Revisada
                    </Link>
                </div>
                <div class="mx-1">
                    <Link v-if ="$page.props.user.permissions.includes('Aporbacion Liberacion') && props.liberacion.libe_estado === 1" :href="route('liberacion.aprobacion', { estado: 2, id: props.liberacion.id})"
                    class="inline-block rounded-md bg-green-500 px-4 py-2 text-white hover:bg-green-400 text-sm">
                    <i class="fa-solid fa-file-circle-check" style="color: #ffffff;"></i> Aprobar Liberación
                    </Link>
                </div>
                <div class="mx-1">
                    <a v-if ="$page.props.user.permissions.includes('Generar Carta Liberacion') && props.liberacion.libe_estado === 2"
                    :href="route('liberacion.pdf', props.liberacion.id)" target="_blank"
                    class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm">
                    <i class="fa-regular fa-file-pdf fa-lg" style="color: #ffffff;"></i> Generar Carta Liberacion</a>
                </div>
            </div>
        </div>
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <InputLabel value="Datos de Conocimiento de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Nave / Viaje"/>
                                    <TextDisabled type="text" class="mt-2 block w-full" v-model="form.libe_nave_viaje" disabled
                                    placeholder="Ej. MCS POLONIA III - PM430R"/>
                                    <InputError :message="form.errors.libe_nave_viaje" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Bill Of Lading"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full" v-model="form.libe_bl" disabled
                                    placeholder="Ej. MEDUX8013096"></TextDisabled>
                                    <InputError :message="form.errors.libe_bl" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Puerto de Descarga"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full" v-model="form.libe_puerto" disabled
                                    placeholder="Ej. QINGDAO, CHINA"></TextDisabled>
                                    <InputError :message="form.errors.libe_puerto" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Nombre Consignatario"/>
                                    <TextDisabled type="text" class="mt-2 block w-full" v-model="form.libe_consignatario" disabled
                                    placeholder="Ej. Qingdao Sinorail Logistics CO."/>
                                    <InputError :message="form.errors.libe_consignatario" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Direccion Consignatario"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full" v-model="form.libe_direccion" disabled
                                    placeholder="Ej. 1106, A Building, Vake Center, Nro. 2 South"></TextDisabled>
                                    <InputError :message="form.errors.libe_direccion" class="mt-2"></InputError>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Documentos para la liberación" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <div class="grid grid-cols-3 gap-1 mt-1" v-for="(doc, index) in documentos" :key="index">
                        <div>
                            <InputLabel :value="doc.label"></InputLabel>
                        </div>
                        <div>
                            <TextDisabled
                            v-model="doc.nro"
                            type="text"
                            class="mt-2 block w-full"
                            :placeholder="doc.placeholder"
                            required
                            disabled
                            :class="{ 'opacity-50': isDisabled }"
                            />
                        </div>
                        <div class="flex flex-row items-center mt-2">
                            <GreenButton v-if="doc.pdf" @click="openDocument(doc.pdf)">
                                <i class="fa-regular fa-file-pdf" style="color: #ffffff;"></i>
                            </GreenButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br>
    <div v-if="props.liberacion.libe_estado === 2" class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <div >
                        <InputLabel value="Subir Documentos" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                        <br>
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <InputLabel value="Carta de Liberacion Firmada"/>
                            </div>
                            <div>
                                <form v-if="props.liberacion.pdf_cartaliberacion === null"
                                    @submit.prevent="handleSubmit('carta')" class="flex flex-row items-center mt-2 px-4">
                                    <input type="hidden" name="document_type" value="carta" />
                                    <input type="file" @change="handleFileUpload" accept=".pdf" required />
                                    <GreenButton type="submit" :disabled="processing">Subir</GreenButton>

                                </form>
                                <GreenButton v-else>
                                    <a :href="getFileUrl(props.liberacion.pdf_cartaliberacion)" target="_blank">Ver PDF</a>
                                </GreenButton>

                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <InputLabel value="Sea Way Bill"/>
                            </div>
                            <div>
                                <form v-if="props.liberacion.pdf_seawaybill === null"
                                    @submit.prevent="handleSubmit('seaway')" class="flex flex-row items-center mt-2 px-4">
                                    <input type="hidden" name="document_type" value="seaway" />
                                    <input type="file" @change="handleFileUpload" accept=".pdf" required />
                                    <GreenButton type="submit" :disabled="processing">Subir</GreenButton>
                                </form>
                                <GreenButton v-else>
                                    <a :href="getFileUrl(props.liberacion.pdf_seawaybill)" target="_blank">Ver PDF</a>
                                </GreenButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
