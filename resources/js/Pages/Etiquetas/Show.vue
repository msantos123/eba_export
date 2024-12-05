<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import BlueButton from '@/Components/BlueButton.vue';
import GreenButton from '@/Components/GreenButton.vue';
import * as XLSX from 'xlsx';
import WarningButton from '@/Components/WarningButton.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    detallesGuardados: { type: Object },
});
const nombreEtiqueta = ref('');
const content = ref('');
const modal = ref(false);
const modalContent = ref(false);
const etiquetas = ref([]);

const openModal = () => {
    modal.value = true;
};
const closeModal = () => {
    modal.value = false;
    modalContent.value = false;
}


//codigo para el cuadro de texto
import Quill from 'quill';
import axios from 'axios';
import TextInput from '@/Components/TextInput.vue';

const editor = ref(null);
let quill;

const addTag = (tag) => {
  const range = quill.getSelection();
  quill.insertText(range.index, tag);
};;

onMounted(() => {
  quill = new Quill(editor.value, {
    theme: 'snow',
    modules: {
      toolbar: [
        ['bold', 'italic', 'underline'],
        ['link', 'image', 'table'],
        [{ 'align': [] }],
        [{ 'size': [] }],
        ['clean']
      ],
      table:true
    }
  });
});

const cargaEtiqueta = (contenido) => {
    const parsedContent = JSON.parse(contenido);
    quill.root.innerHTML = parsedContent.content || '';
    modalContent.value = false;
};

const saveContent = async () => {
    modalContent.value = true;

    try {
        const response = await axios.get('/etiquetas/verEtiquetas');
        etiquetas.value = response.data;
        console.log(response);
    } catch (error) {
        console.error("Error al generar PDF:",error);
    }
}

const deleteEtiqueta = async (id) => {
    try {
        const response = await axios.delete(`/etiquetas/eliminarEtiqueta/${id}`);
        console.log(response);
        etiquetas.value = etiquetas.value.filter(etiqueta => etiqueta.id !== id);
        console.log("Etiqueta eliminada correctamente");
    } catch (error) {
        console.error("Error al eliminar la etiqueta:", error);
    }
};

const guardarEtiqueta = async () => {
    const saveContent = quill.root.innerHTML;
    const nombreEtiquetaValue = nombreEtiqueta.value;

    if (!saveContent || saveContent.trim() === "<p><br></p>" || saveContent.trim() === "<p></p>") {
        showMessageWithText('El formato de etiqueta no puede estar vacío.');
        return;
    }
    if (!nombreEtiquetaValue) {
        showMessageWithText('El nombre de la etiqueta no puede estar vacío.');
        return;
    }

    modalContent.value = true;
    const requestDataGuardar = {
        saveContent: JSON.stringify({ content: saveContent }),
        nombreEtiqueta: nombreEtiquetaValue,
    };

    try {
        await axios.post('/etiquetas/guardarEtiqueta', requestDataGuardar);

        Swal.fire({
            title: '¡Guardado!',
            text: 'La etiqueta ha sido guardada con exito.',
            icon: 'success',
            willClose: () => {
                nombreEtiqueta.value = '';
                closeModal();
            }
        });

    } catch (error) {
        console.error("Error al guardar la etiqueta:", error);
        showMessageWithText('Error al guardar la etiqueta. Intenta nuevamente.');
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

const saveToPDF = async () => {
  const content = quill.root.innerHTML;
  if (!content || content.trim() === "<p><br></p>" || content.trim() === "<p></p>") {
        showMessageWithText('El formato de etiqueta no puede estar vacío.');
        return;
    }
  const detallesGuardados = Array.from(props.detallesGuardados);
  const requestData = {
    content,
    detallesGuardados
  };

  try {
    const response = await axios.post('/etiquetas/etiquetasPdf', requestData, {
      responseType: 'blob'
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'etiquetas-generadas.pdf');
    link.click();
    link.remove();
  } catch (error) {
    console.error("Error al generar PDF:", error);
  }
};

const etiquetasChinita = async () => {
  const detallesGuardados = Array.from(props.detallesGuardados);
  const requestData = {
    detallesGuardados
  };

  try {
    const response = await axios.post('/etiquetas/etiquetasChina', requestData, {
        responseType: 'blob'
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'etiquetas-china.pdf');
    link.click();
    link.remove();
  } catch (error) {
    console.error("Error al generar PDF:", error);
  }
};

const exportToExcel = () => {
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.json_to_sheet(props.detallesGuardados);
  XLSX.utils.book_append_sheet(wb, ws, 'Datos');
  XLSX.writeFile(wb, 'datos.xlsx');
};
</script>
<style>
.editor {
    height: 200px;
}

.mr-2 {
    margin-right: 0.5rem;
}
</style>
<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            Generar Etiquetas
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('etiquetas.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <BlueButton @click="$event=>openModal()">
                            <i class="fa-solid fa-eye" style="color: #ffffff;"></i> Ver Detalle de Etiquetas
                    </BlueButton>
                </div>
                <div class="mx-1">
                    <BlueButton @click="$event=>exportToExcel()">
                        <i class="fa-regular fa-file-excel" style="color: #ffffff;"></i> Exporta en Excel
                    </BlueButton>
                </div>
            </div>
        </div>
        <div v-if="showMessage" class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-red-200 shadow-md">
            <div class="px-4 py-3 flex">
                <div class="text-red-500">
                    {{ message }}
                </div>
            </div>
        </div>
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Formato de Etiquetas" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <div>
                        <div ref="editor" class="editor" />
                    </div>
                    <br>
                    <div>
                        <GreenButton @click="addTag(`*LOTE*`)" class="mr-2">Agregar Lote</GreenButton>
                        <GreenButton @click="addTag(`*FECHA-ENVASADO*`)" class="mr-2">Agregar Fecha Envasado</GreenButton>
                    </div>
                    <br>
                    <div>
                        <GreenButton class="inline-block rounded-md bg-purple-500 px-4 py-2 text-white hover:bg-purple-400 text-sm mr-2"
                        @click="saveContent">Ver Etiquetas Guardadas</GreenButton>
                        <a class="inline-block rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-400 text-sm mr-2"
                        @click="saveToPDF" target="_blank">Generar Etiquetas</a>
                        <a class="inline-block rounded-md bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-400 text-sm mr-2"
                        @click="etiquetasChinita" target="_blank">China</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>

    <Modal :show="modal" @close="closeModal">
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider"></div>
                    <h2 class="p-3 text-lg font-medium text-gray-900">Ver Detalle de Fechas</h2>
                        <div class="p-3">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 p-2">#</th>
                                        <th class="border border-gray-300 p-2">Producto</th>
                                        <th class="border border-gray-300 p-2">Nro. Lote</th>
                                        <th class="border border-gray-300 p-2">Cantidad</th>
                                        <th class="border border-gray-300 p-2">Fecha Elaboracion</th>
                                        <th class="border border-gray-300 p-2">Fecha Envasado</th>
                                        <th class="border border-gray-300 p-2">Fecha Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(detalle, index) in detallesGuardados" :key="index">
                                        <td class="border border-gray-300 p-2">{{ index + 1 }}</td>
                                        <td class="border border-gray-300 p-2">{{ detalle.rece_nombre }}</td>
                                        <td class="border border-gray-300 p-2">{{ detalle.lote_detalle }}</td>
                                        <td class="border border-gray-300 p-2">{{ detalle.cantidad_salida }}</td>
                                        <td class="border border-gray-300 p-2">{{ detalle.fecha_elaboracion }}</td>
                                        <td class="border border-gray-300 p-2">{{ detalle.fecha_envasado }}</td>
                                        <td class="border border-gray-300 p-2">{{ detalle.fecha_vencimiento }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </Modal>


    <Modal :show="modalContent" @close="closeModal">
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider"></div>
                    <h2 class="p-3 text-lg font-medium text-gray-900">Guardar Etiqueta</h2>
                        <div class="p-3">
                            <div class="p-3">
                                <TextInput v-model="nombreEtiqueta" placeholder="Nombre de la Etiqueta"/>
                            </div>
                            <div v-if="showMessage" class="inline-flex w-full overflow-hidden rounded-lg bg-red-200 shadow-md">
                                <div class="px-4 py-3 flex">
                                    <div class="text-red-500">
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <table class="min-w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2">Nombre</th>
                                            <th class="border border-gray-300 px-4 py-2">Fecha de Creacion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="etiqueta in etiquetas" :key="etiqueta.id">
                                            <td class="border border-gray-300 px-4 py-2">{{ etiqueta.eti_nombre }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ new Date(etiqueta.created_at).toLocaleDateString() }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <GreenButton @click="() => cargaEtiqueta(etiqueta.eti_contenido)">
                                                    <i class="fa-solid fa-circle-plus"></i>
                                                </GreenButton>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <WarningButton @click="() => deleteEtiqueta(etiqueta.id)">
                                                <i class="fa-solid fa-trash"></i></WarningButton>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3">
                                <GreenButton @click="guardarEtiqueta" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    Guardar Etiqueta</GreenButton>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
