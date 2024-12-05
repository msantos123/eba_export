<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import GreenButton from '@/Components/GreenButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const props = defineProps({
    pdfs: { type: Object },
});

//guardarPDF
const documentos = ref([
  { label: "Contrato de Venta", nro: "", archivo: null, subido: false, placeholder: "Nro. Contrato" },
  { label: "Factura Comercial", nro: "", archivo: null, subido: false, placeholder: "Nro. Factura" },
  { label: "Lista de Empaque", nro: "", archivo: null, subido: false, placeholder: "Nro. Empaque" },
  { label: "B/L Bill of Lading", nro: "", archivo: null, subido: false, placeholder: "SEA WAYBILL No." },
  { label: "Fitosanitario", nro: "", archivo: null, subido: false, placeholder: "Nro. Fitosanitario" },
  { label: "Inocuidad Alimentaria", nro: "", archivo: null, subido: false, placeholder: "Nro. Inocuidad Alimentaria" },
  { label: "Test Repost", nro: "", archivo: null, subido: false, placeholder: "Nro. Test Repost" },
  { label: "Certificado de Origen", nro: "", archivo: null, subido: false, placeholder: "Nro. Certificado de Origen" },
  { label: "DEX", nro: "", archivo: null, subido: false, placeholder: "Nro. DEX" },
  { label: "Certificado de Salida ANB", nro: "", archivo: null, subido: false, placeholder: "Nro. Cert. de Salida ANB" },
  { label: "MIC/DTA", nro: "", archivo: null, subido: false, placeholder: "Nro. MIC/DTA" },
  { label: "CRT", nro: "", archivo: null, subido: false, placeholder: "Nro. CRT" },
  { label: "CFO", nro: "", archivo: null, subido: false, placeholder: "Nro. CFO" },
  { label: "Comprobante de Salida (Fotografias)", nro: "", archivo: null, subido: false, placeholder: "Nro. Comprobante de Salida" },
  { label: "EIR Gate Out", nro: "", archivo: null, subido: false, placeholder: "Nro. de EIR Gate Out" },
  { label: "Carta de Envio de Documentos (Transportista)", nro: "", archivo: null, subido: false, placeholder: "Nro. Carta" },
  { label: "Carta de Envio de Documentos (Cliente)", nro: "", archivo: null, subido: false, placeholder: "Nro. Carta" },
  { label: "Otros Documentos", nro: "", archivo: null, subido: false, placeholder: "Descripcion Otros Documentos" },
]);
const isDisabled = ref(false);
const documentosTemp = ref([]);
const handleFileUpload = (index, event) => {
  const file = event.target.files[0];
  if (file) {
    documentos.value[index].archivo = file;
  }
};

const handleAddDocument = (index) => {
  const doc = documentos.value[index];
  if (doc.nro && doc.archivo) {
    documentosTemp.value.push({ nro: doc.nro, archivo: doc.archivo });
    doc.subido = true; // Marcar como subido
    console.log(documentosTemp.value);
  } else {
    alert("Por favor, completa el número y selecciona un archivo.");
  }
};

const router = useRouter();
const handleSubmitAll = async () => {
  const formData = new FormData();
  formData.append('factura', props.comprobanteSalida.factura);

  documentosTemp.value.forEach(doc => {
    formData.append('documentos[]', doc.archivo);
    formData.append('nros[]', doc.nro);
  });

  isDisabled.value = true;
  try {
    await enviarDoc(formData);
    // Limpiar el arreglo temporal y los documentos
    documentosTemp.value = [];
    documentos.value.forEach(doc => {
      doc.nro = "";
      doc.archivo = null;
      doc.subido = false;
    });
  } catch (error) {
    console.error('Error al enviar todos los documentos:', error);
  } finally {
    isDisabled.value = false; // Habilitar después de la subida
    //window.location.href = "route()";
  }
};

const enviarDoc = async (formData) => {
  console.log("ENVIAR DOC", [...formData]);
  try {
    const response = await axios.post('/tracking/liberacion', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    console.log('Archivos subidos exitosamente:', response);
  } catch (error) {
    console.error('Error al subir el archivo:', error.response ? error.response.data : error.message);
  }
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
            Liberación de Contenedor - Factura Nro. {{ props.pdfs.factura }}
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('tracking.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <GreenButton @click.prevent="handleSubmitAll"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-save" style="color: #ffffff;"></i> Guardar Documentos
                    </GreenButton>
                </div>
            </div>
        </div>
        {{ props.pdfs }}
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Documentos para la liberación" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <div class="grid grid-cols-4 gap-4 mt-4" v-for="(doc, index) in documentos" :key="index">
                        <div>
                            <InputLabel :value="doc.label"></InputLabel>
                        </div>
                        <div>
                            <TextInput
                            v-model="doc.nro"
                            type="text"
                            class="mt-2 block w-full"
                            :placeholder="doc.placeholder"
                            required
                            :disabled="isDisabled"
                            :class="{ 'opacity-50': isDisabled }"
                            />
                        </div>
                        <div v-if="!doc.subido" class="flex flex-row items-center mt-2">
                            <input
                            class="flex-1 mr-2"
                            type="file"
                            @change="(event) => handleFileUpload(index, event)"
                            accept=".pdf"
                            required
                            />
                            <GreenButton
                            v-if="!doc.subido"
                            @click.prevent="() => handleAddDocument(index)"
                            class="ml-2 py-1 px-2 text-sm"
                            >
                            Subir
                            </GreenButton>
                        </div>
                        <div v-if="doc.subido" class="flex flex-row items-center mt-2">
                            <i class="fa-solid fa-file-circle-check fa-2xl" style="color: #31ef0b;"></i>
                            <span class="ml-2">Nombre del Documento: {{ doc.archivo.name }}</span>
                            <WarningButton
                            v-if="doc.subido"
                            @click="() => resetFile(index)"
                            class="ml-2 py-1 px-2 text-sm"
                            >
                            Volver
                            </WarningButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </AuthenticatedLayout>
</template>
