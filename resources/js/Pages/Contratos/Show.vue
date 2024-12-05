<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps, ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import TextAreaDisabled from '@/Components/TextAreaDisabled.vue';
import GreenButton from '@/Components/GreenButton.vue';

const props = defineProps({
    contrato: { type: Object },
});

const contenido = JSON.parse(props.contrato.ctrt_contenido);

const form = useForm({
    ctrt_codigo: props.contrato.ctrt_codigo,
    ctrt_fecha_contrato: props.contrato.ctrt_fecha,
    ctrt_vendedor: contenido.ctrt_vendedor,
    ctrt_comprador: contenido.ctrt_comprador,
    ctrt_direccion_comprador: contenido.ctrt_direccion_comprador,
    ctrt_producto: contenido.ctrt_producto,
    ctrt_precio: contenido.ctrt_precio,
    ctrt_medida: contenido.ctrt_medida,
    ctrt_terminos_envio: contenido.ctrt_terminos_envio,
    ctrt_embarque: contenido.ctrt_embarque,
    ctrt_empaque: contenido.ctrt_empaque,
    selectedAnalisis: contenido.selectedAnalisis,
    ctrt_pago: contenido.ctrt_pago,
    ctrt_cantidad: contenido.ctrt_cantidad,
    ctrt_por_anticipo: contenido.ctrt_por_anticipo,
    ctrt_por_pago: contenido.ctrt_por_pago,
    ctrt_terminos: contenido.ctrt_terminos,
    ctrt_doc_vendedor: contenido.ctrt_doc_vendedor,
    ctrt_doc_comprador: contenido.ctrt_doc_comprador,
    ctrt_adicional_etiqueta: contenido.ctrt_adicional_etiqueta,
    ctrt_adicional_contenido: contenido.ctrt_adicional_contenido,
});

//codigo para el cuadro de texto
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
  formData.append('contrato_id', props.contrato.id); // Cambiado a conocimiento_id

  processing.value = true;

  try {
    const response = await axios.post('/contratos/upload', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });

    filePath.value = response.data.path;
    fileName.value = response.data.file_name;

    // Genera la URL para acceder al archivo
    const fileUrl = getFileUrl(fileName.value);

  } catch (error) {
    console.error('Error al subir el archivo:', error);
  } finally {
    location.reload();
    processing.value = false;
  }
};

const getFileUrl = (file) => {
  return `${window.location.origin}/storage/contratos/${file}`;
};

</script>
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
.editor {
  height: 200px;
}
.custom-line {
  border: 0; /* Elimina el borde por defecto */
  height: 1px; /* Altura de la línea */
  background-color: #000; /* Color de la línea */
  margin: 20px 0; /* Margen arriba y abajo */
}
</style>
<template>
    <Head title="Comprobante de Salida" />
    <AuthenticatedLayout>
        <template #header>
            Ver Contrato
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('contratos.index')"
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
                    <InputLabel value="Formato de Etiquetas" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Contrato Nro."></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_codigo" disabled></TextDisabled>
                                </div>
                                <div>
                                    <InputLabel value="Fecha de Contrato"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_fecha_contrato"></TextDisabled>
                                    <InputError :message="form.errors.ctrt_fecha_contrato" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Vendedor"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_vendedor" disabled></TextDisabled>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Comprador"></InputLabel>
                                    <TextAreaDisabled v-model="form.ctrt_comprador"
                                    required class="mt-2 block w-full" disabled></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_comprador"  class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Direccion del Comprador"></InputLabel>
                                    <TextAreaDisabled v-model="form.ctrt_direccion_comprador"
                                    required class="mt-2 block w-full"></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_direccion_comprador" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Producto"></InputLabel>
                                    <TextAreaDisabled class="mt-2 block w-full"
                                    v-model="form.ctrt_producto" required></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_producto" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Precio"></InputLabel>
                                    <TextDisabled type="number" class="mt-2 block w-full"
                                    v-model="form.ctrt_precio" required></TextDisabled>
                                    <InputError :message="form.errors.ctrt_precio" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Medida"></InputLabel>
                                    <select v-model="form.ctrt_medida" @change="updatePago" disabled class="mt-2 block w-full border rounded">
                                        <option value="">Selecciona una medida</option>
                                        <option value="Tn">Tonelada Metrica (Tn)</option>
                                        <option value="lb">Libra (lb)</option>
                                        <option value="kg">Kilogramo (kg)</option>
                                        <option value="g">Gramos (g)</option>
                                    </select>
                                    <InputError :message="form.errors.ctrt_medida" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Terminos de Envio"></InputLabel>
                                    <TextAreaDisabled class="mt-2 block w-full"
                                    v-model="form.ctrt_terminos_envio" required ></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_terminos_envio" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Embarque"></InputLabel>
                                    <TextAreaDisabled class="mt-2 block w-full"
                                    v-model="form.ctrt_embarque"required></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_embarque" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Empaque"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_empaque" required></TextDisabled>
                                    <InputError :message="form.errors.ctrt_empaque" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <div>
                                <InputLabel value="Análisis"></InputLabel>
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    <div>
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                id="checkbox1"
                                                :value="'Pesticidas'"
                                                @change="updateOptions"
                                                :checked="form.selectedAnalisis.includes('Pesticidas')"
                                                class="mr-2"
                                                disabled
                                            />
                                            <label>Pesticidas</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input
                                                type="checkbox"
                                                id="checkbox2"
                                                :value="'Glisofatos'"
                                                @change="updateOptions"
                                                :checked="form.selectedAnalisis.includes('Glisofatos')"
                                                class="mr-2"
                                                disabled
                                            />
                                            <label>Glisofatos</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input
                                                type="checkbox"
                                                id="checkbox3"
                                                :value="'Fosetil Aluminio'"
                                                @change="updateOptions"
                                                :checked="form.selectedAnalisis.includes('Fosetil Aluminio')"
                                                class="mr-2"
                                                disabled
                                            />
                                            <label>Fosetil Aluminio</label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center mt-2">
                                            <input
                                                type="checkbox"
                                                id="checkbox4"
                                                :value="'Análisis Aflatoxina Totales'"
                                                @change="updateOptions"
                                                :checked="form.selectedAnalisis.includes('Análisis Aflatoxina Totales')"
                                                class="mr-2"
                                                disabled
                                            />
                                            <label>Análisis Aflatoxina Totales</label>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <input
                                                type="checkbox"
                                                id="checkbox5"
                                                :value="'Análisis de Gluten'"
                                                @change="updateOptions"
                                                :checked="form.selectedAnalisis.includes('Análisis de Gluten')"
                                                class="mr-2"
                                                disabled
                                            />
                                            <label>Análisis de Gluten</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="grid grid-cols-3 gap-4 mt-1">
                                <div>
                                    <InputLabel value="Cantidad"></InputLabel>
                                    <TextDisabled type="number" required class="mt-2 block w-full"
                                    v-model="form.ctrt_cantidad" ></TextDisabled>
                                    <InputError :message="form.errors.ctrt_cantidad" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Anticipo (%)"></InputLabel>
                                    <TextDisabled type="number" required class="mt-2 block w-full"
                                    v-model="form.ctrt_por_anticipo" ></TextDisabled>
                                    <InputError :message="form.errors.ctrt_por_anticipo" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Pago (%)"></InputLabel>
                                    <TextDisabled type="number" required class="mt-2 block w-full"
                                    v-model="form.ctrt_por_pago" ></TextDisabled>
                                    <InputError :message="form.errors.ctrt_por_pago" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Pago"></InputLabel>
                                    <TextAreaDisabled v-model="form.ctrt_pago" required
                                    class="mt-2 block w-full" row="5"></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_pago" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Términos y condiciones"></InputLabel>
                                    <TextAreaDisabled required class="mt-2 block w-full"
                                    v-model="form.ctrt_terminos" ></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_terminos" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <InputLabel value="Documentos Requeridos"></InputLabel>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Enviado por el Vendedor"></InputLabel>
                                    <TextAreaDisabled required class="mt-2 block w-full"
                                    v-model="form.ctrt_doc_vendedor" ></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_doc_vendedor" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Enviado por el Comprador"></InputLabel>
                                    <TextAreaDisabled required class="mt-2 block w-full"
                                    v-model="form.ctrt_doc_comprador" ></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_doc_comprador" class="mt-2"></InputError>
                                </div>
                            </div>
                            <hr class="custom-line" />
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Titulo de Campo Adicional"></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_adicional_etiqueta" ></TextDisabled>
                                </div>
                                <div>
                                    <InputLabel value="Contenido de Campo Adicional"></InputLabel>
                                    <TextAreaDisabled class="mt-2 block w-full"
                                    v-model="form.ctrt_adicional_contenido" ></TextAreaDisabled>
                                    <InputError :message="form.errors.ctrt_adicional_contenido" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <p>*Los campos 'Titulo de Campo Adicional' y 'Contenido de Campo Adicional' son campos adicionales que no se mostraran en el contrato si no tienen contenido.</p>
                        <br>
                    <div>
                        <InputLabel value="Subir Contrato Firmado" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                        <br>
                        <div v-if="props.contrato.pdf_contrato" class="preview-container">
                            <!-- Div izquierdo -->
                            <div class="uploaded-file-info">
                                <h2>Archivo Subido:</h2>
                                <p>Nombre del archivo: {{ props.contrato.pdf_contrato }}</p>
                                <a :href="getFileUrl(props.contrato.pdf_contrato)" target="_blank">Ver PDF</a>
                            </div>

                            <!-- Div derecho para la vista previa -->
                            <div class="pdf-preview">
                                <h2>Vista Previa:</h2>
                                <iframe :src="getFileUrl(props.contrato.pdf_contrato)" class="pdf-iframe" frameborder="0"></iframe>
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
