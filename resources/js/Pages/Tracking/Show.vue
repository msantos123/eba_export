<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import GreenButton from '@/Components/GreenButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import InputError from '@/Components/InputError.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const props = defineProps({
    comprobanteSalida: { type: Object },
});

const form = useForm({
    libe_nave_viaje: '',
    libe_bl: '',
    libe_puerto: '',
    libe_consignatario: '',
    libe_direccion: '',
})

const resetFile = (index) => {
  documentos.value[index].archivo = null;
  documentos.value[index].subido = false;
  documentos.value[index].nro = '';
  isDisabled.value = false;
};

const selectedType = ref('');
//guardarPDF
const filteredDocuments = computed(() => {
    if (!selectedType.value) return documentos.value; // Si no hay tipo seleccionado, mostrar todos
    return documentos.value.filter(doc => doc.tipos.includes(selectedType.value));
});
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
const isDisabled = ref(false);
const documentosTemp = ref([]);
const handleFileUpload = (index, event) => {
  const file = event.target.files[0];
  if (file) {
    documentos.value[index].archivo = file;
  }
};

const message = ref('');
const showMessage = ref(false);
const showMessageWithText = (text) => {
    message.value = text;
    showMessage.value = true;
    setTimeout(() => {
        showMessage.value = false;
    }, 5000);
};

const handleAddDocument = (index) => {
  const doc = documentos.value[index];
  if (doc.nro && doc.archivo) {
    documentosTemp.value.push({ nro: doc.nro, archivo: doc.archivo });
    doc.subido = true;
    console.log(documentosTemp.value);
  } else {
    showMessageWithText('Por favor, complete el nro. documento y suba un archivo.');
  }
};

const handleSubmitAll = async () => {
  const formData = new FormData();
  formData.append('factura', props.comprobanteSalida.factura);
  formData.append('libe_nave_viaje', form.libe_nave_viaje);
  formData.append('libe_bl', form.libe_bl);
  formData.append('libe_puerto', form.libe_puerto);
  formData.append('libe_consignatario', form.libe_consignatario);
  formData.append('libe_direccion', form.libe_direccion);

  documentosTemp.value.forEach(doc => {
    formData.append('documentos[]', doc.archivo);
    formData.append('nros[]', doc.nro);
  });

  isDisabled.value = true;
  try {
    await enviarDoc(formData);
    documentosTemp.value = [];
    documentos.value.forEach(doc => {
      doc.nro = "";
      doc.archivo = null;
      doc.subido = false;
    });
  } catch (error) {
    console.error('Error al enviar todos los documentos:', error);
  } finally {
    isDisabled.value = false;
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

        Swal.fire({
            title: 'Éxito',
            text: 'Los documentos se han subido correctamente.',
            icon: 'success',
            willClose: () => {
                window.location.href = route('tracking.index');
            }
        });


        form.errors = {};

    } catch (error) {
        console.error('Error al subir el archivo:', error.response ? error.response.data : error.message);

        if (error.response && error.response.data.errors) {
            form.errors = error.response.data.errors;
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un problema al subir los documentos. Intenta nuevamente.',
                icon: 'error',
            });
        }
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
            Liberación de Contenedor - Factura Nro. {{ props.comprobanteSalida.factura }}
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

        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <InputLabel value="Datos de Conocimiento de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Nave / Viaje"/>
                                    <TextInput type="text" class="mt-2 block w-full" v-model="form.libe_nave_viaje" required
                                    placeholder="Ej. MCS POLONIA III - PM430R"/>
                                    <InputError :message="form.errors.libe_nave_viaje" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Bill Of Lading"></InputLabel>
                                    <TextInput type="text" class="mt-2 block w-full" v-model="form.libe_bl" required
                                    placeholder="Ej. MEDUX8013096"></TextInput>
                                    <InputError :message="form.errors.libe_bl" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Puerto de Descarga"></InputLabel>
                                    <TextInput type="text" class="mt-2 block w-full" v-model="form.libe_puerto" required
                                    placeholder="Ej. QINGDAO, CHINA"></TextInput>
                                    <InputError :message="form.errors.libe_puerto" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Nombre Consignatario"/>
                                    <TextInput type="text" class="mt-2 block w-full" v-model="form.libe_consignatario" required
                                    placeholder="Ej. Qingdao Sinorail Logistics CO."/>
                                    <InputError :message="form.errors.libe_consignatario" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Direccion Consignatario"></InputLabel>
                                    <TextInput type="text" class="mt-2 block w-full" v-model="form.libe_direccion" required
                                    placeholder="Ej. 1106, A Building, Vake Center, Nro. 2 South"></TextInput>
                                    <InputError :message="form.errors.libe_direccion" class="mt-2"></InputError>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <GreenButton @click="selectedType = 'CRF - FOB'">CFR - FOB</GreenButton>
                </div>
                <div class="mx-1">
                    <GreenButton @click="selectedType = 'EXWORD'">EXWORD</GreenButton>
                </div>
            </div>
        </div>
        <div v-if="showMessage" class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-red-200 shadow-md">
            <div class="px-4 py-3 flex">
                <div  class="text-red-500">
                    {{ message }}
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Documentos para la liberación" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <div class="grid grid-cols-4 gap-4 mt-4" v-for="(doc, index) in filteredDocuments" :key="index">
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
