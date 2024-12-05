<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import GreenButton from '@/Components/GreenButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import TextArea from '@/Components/TextArea.vue';
import { watch } from 'vue';

const form = useForm({
    ctrt_codigo:'',
    ctrt_fecha_contrato: new Date().toISOString().slice(0, 10),
    ctrt_vendedor: 'EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS - EBA.',
    ctrt_comprador: '',
    ctrt_direccion_comprador:'',
    ctrt_producto: '',
    ctrt_precio: '',
    ctrt_precio_html: '',
    ctrt_medida: '',
    ctrt_terminos_envio: '',
    ctrt_embarque: 'El despacho será de acuerdo a coordinación entre partes; según las instrucciones de embarque del comprador, recibidas oportunamente. El despacho dependerá de que no existan cambios en la información para la documentación de exportación y esta sea remitida oportunamente.',
    ctrt_empaque: '',
    selectedAnalisis: [],
    ctrt_pago: `Total valor (100%), debe ser pagada como sigue:
- Cantidad del producto:
- 100% (Valor total) USD:
- Anticipo (0%): USD
- Pago (0%): USD`,
    ctrt_pago_html:'',
    ctrt_cantidad: 0,
    ctrt_por_anticipo: 0,
    ctrt_por_pago: 0,
    ctrt_terminos: `Este documento constituye el total del contrario sin que se acepte ningún otro documento.
La exposición de términos constituyen la declaración completa y exclusiva de los términos y condiciones del contrato celebrado entre ambas partes (comprador y vendedor).
Cualquier modificación antes de la firma del contrato solo puede aceptarse con el acuerdo del vendedor y el comprador
Las controversias o reclamos derivadas o relacionadas con este contrato se resolverán mediante acuerdos entre ambas partes, en caso de no acuerdo, se acordará el lugar del arbitraje por ambas partes.
Este contrato está sujeto a contingencias de fuerza mayor.
Los reclamos, deben presentarse dentro de los 10 días siguientes al arribo de la mercancía, mostrando la especificación del reclamo, mientras los productos estén intactos o no estén abiertos/manipulados, el reclamo debe estar justificado y respaldado por un tercero.`,
    ctrt_doc_vendedor: '',
    ctrt_doc_comprador: '',
    ctrt_adicional_etiqueta:'',
    ctrt_adicional_contenido: '',
});

const updatePago = async() => {

  const cantidad = parseFloat(form.ctrt_cantidad) || 0;
  const precio = parseFloat(form.ctrt_precio) || 0;

  if (form.ctrt_medida && form.ctrt_por_anticipo !== undefined && form.ctrt_por_pago !== undefined) {

    const totalValor = cantidad * precio;
    const anticipo = (totalValor * (form.ctrt_por_anticipo / 100)).toFixed(2);
    const pago = (totalValor * (form.ctrt_por_pago / 100)).toFixed(2);

    // Contenido para el PDF
    form.ctrt_pago_html = `Total valor (100%), debe ser pagada como sigue:<br>` +
        `- Cantidad del producto: ${cantidad} ${form.ctrt_medida}<br>` +
        `- 100% (Valor total) USD: ${totalValor.toFixed(2)}.- ( )<br>` +
        `- Anticipo (${form.ctrt_por_anticipo}%): USD ${anticipo}.- ( )<br>` +
        `- Pago (${form.ctrt_por_pago}%): USD ${pago}.- ( )<br>`;

    // Contenido para mostrar en la vista
    form.ctrt_pago = `Total valor (100%), debe ser pagada como sigue:\n` +
        `- Cantidad del producto: ${cantidad} ${form.ctrt_medida}\n` +
        `- 100% (Valor total) USD: ${totalValor.toFixed(2)}.- ( )\n` +
        `- Anticipo (${form.ctrt_por_anticipo}%): USD ${anticipo}.- ( )\n` +
        `- Pago (${form.ctrt_por_pago}%): USD ${pago}.- ( )\n`;

    form.ctrt_precio_html = `${form.ctrt_precio} $/`+`${form.ctrt_medida}`;

  } else {
        console.warn('Una de las propiedades necesarias está indefinida');
    }
};

watch(
  () => [
    form.ctrt_precio,
    form.ctrt_cantidad,
    form.ctrt_por_anticipo,
    form.ctrt_por_pago,
    form.ctrt_precio,
    form.ctrt_medida
],
  (newValues) => {
    if (newValues.every(value => value !== undefined && value !== null)) {
      updatePago();
    }else {
            console.warn('Hay valores indefinidos en el watch');
        }
  }
);

const updateOptions = (event) => {
    const option = event.target.value;
    if (event.target.checked) {
        form.selectedAnalisis.push(option);
    } else {
        form.selectedAnalisis = form.selectedAnalisis.filter(item => item !== option);
    }
};

const submitForm = () => {
    form.post(route('contratos.store'), {
    });
}
</script>

<style scoped>
.custom-line {
  border: 0; /* Elimina el borde por defecto */
  height: 1px; /* Altura de la línea */
  background-color: #000; /* Color de la línea */
  margin: 20px 0; /* Margen arriba y abajo */
}
</style>

<template>
    <Head title="Crear Contrato" />
    <AuthenticatedLayout>
        <template #header>
            Crear Contrato de Exportación
        </template>
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md" >
            <div class="px-4 py-3 flex">
                <div class="mx-1">
                    <Link :href="route('contratos.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
                </div>
                <div class="mx-1">
                    <GreenButton :disabled="form.processing" @click.prevent="submitForm(form)">
                    <i class="fa-solid fa-save"></i> Guardar como Borrador</GreenButton>
                </div>
            </div>
        </div>
        <div class="min-w-full overflow-x-auto rounded-lg shadow">
            <div class="w-full whitespace-no-wrap">
                <div class="border-b bg-gray-50 text-left tracking-wide text-gray-500">
                    <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                        <InputLabel value="Datos de Conocimiento de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                        <form>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Contrato Nro."></InputLabel>
                                    <TextDisabled type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_codigo" disabled></TextDisabled>
                                </div>
                                <div>
                                    <InputLabel value="Fecha de Contrato"></InputLabel>
                                    <TextInput type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_fecha_contrato"></TextInput>
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
                                    <TextArea v-model="form.ctrt_comprador"
                                    required class="mt-2 block w-full"></TextArea>
                                    <InputError :message="form.errors.ctrt_comprador" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Direccion del Comprador"></InputLabel>
                                    <TextArea v-model="form.ctrt_direccion_comprador"
                                    required class="mt-2 block w-full"></TextArea>
                                    <InputError :message="form.errors.ctrt_direccion_comprador" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Producto"></InputLabel>
                                    <TextArea class="mt-2 block w-full"
                                    v-model="form.ctrt_producto" required></TextArea>
                                    <InputError :message="form.errors.ctrt_producto" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Precio"></InputLabel>
                                    <TextInput type="number" class="mt-2 block w-full"
                                    v-model="form.ctrt_precio" required></TextInput>
                                    <InputError :message="form.errors.ctrt_precio" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Medida"></InputLabel>
                                    <select v-model="form.ctrt_medida" @change="updatePago" required class="mt-2 block w-full border rounded">
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
                                    <TextArea class="mt-2 block w-full"
                                    v-model="form.ctrt_terminos_envio" required ></TextArea>
                                    <InputError :message="form.errors.ctrt_terminos_envio" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Embarque"></InputLabel>
                                    <TextArea class="mt-2 block w-full"
                                    v-model="form.ctrt_embarque"required></TextArea>
                                    <InputError :message="form.errors.ctrt_embarque" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Empaque"></InputLabel>
                                    <TextInput type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_empaque" required></TextInput>
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
                                    <TextInput type="number" required class="mt-2 block w-full"
                                    v-model="form.ctrt_cantidad" ></TextInput>
                                    <InputError :message="form.errors.ctrt_cantidad" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Anticipo (%)"></InputLabel>
                                    <TextInput type="number" required class="mt-2 block w-full"
                                    v-model="form.ctrt_por_anticipo" ></TextInput>
                                    <InputError :message="form.errors.ctrt_por_anticipo" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Pago (%)"></InputLabel>
                                    <TextInput type="number" required class="mt-2 block w-full"
                                    v-model="form.ctrt_por_pago" ></TextInput>
                                    <InputError :message="form.errors.ctrt_por_pago" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Pago"></InputLabel>
                                    <TextArea v-model="form.ctrt_pago" required
                                    class="mt-2 block w-full" row="5"></TextArea>
                                    <InputError :message="form.errors.ctrt_pago" class="mt-2"></InputError>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Términos y condiciones"></InputLabel>
                                    <TextArea required class="mt-2 block w-full"
                                    v-model="form.ctrt_terminos" ></TextArea>
                                    <InputError :message="form.errors.ctrt_terminos" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <InputLabel value="Documentos Requeridos"></InputLabel>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Enviado por el Vendedor"></InputLabel>
                                    <TextArea required class="mt-2 block w-full"
                                    v-model="form.ctrt_doc_vendedor" ></TextArea>
                                    <InputError :message="form.errors.ctrt_doc_vendedor" class="mt-2"></InputError>
                                </div>
                                <div>
                                    <InputLabel value="Enviado por el Comprador"></InputLabel>
                                    <TextArea required class="mt-2 block w-full"
                                    v-model="form.ctrt_doc_comprador" ></TextArea>
                                    <InputError :message="form.errors.ctrt_doc_comprador" class="mt-2"></InputError>
                                </div>
                            </div>
                            <hr class="custom-line" />
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <InputLabel value="Titulo de Campo Adicional"></InputLabel>
                                    <TextInput type="text" class="mt-2 block w-full"
                                    v-model="form.ctrt_adicional_etiqueta" ></TextInput>
                                </div>
                                <div>
                                    <InputLabel value="Contenido de Campo Adicional"></InputLabel>
                                    <TextArea class="mt-2 block w-full"
                                    v-model="form.ctrt_adicional_contenido" ></TextArea>
                                    <InputError :message="form.errors.ctrt_adicional_contenido" class="mt-2"></InputError>
                                </div>
                            </div>
                            <br>
                            <p>*Los campos 'Titulo de Campo Adicional' y 'Contenido de Campo Adicional' son campos adicionales que no se mostraran en el contrato si no tienen contenido.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
