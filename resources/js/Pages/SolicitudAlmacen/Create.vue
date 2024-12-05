<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import WarningButton from '@/Components/WarningButton.vue';
import TextDisabled from '@/Components/TextDisabled.vue';
import GreenButton from '@/Components/GreenButton.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    inventarioAlmacenes: { type: Object },
    planta:{ type: Object },
});

const form = useForm({
    planta_id:props.planta.planta_id,
    carga: [],
});

const descripcion = ref('Cajas de Almendras');
const carga = ref([]);

const add = () => {
    if (validateInputs()) {
        console.log('Datos válidos. Procediendo con la adición...');
    // Verificar si el código de inventario ya está en carga.value
    const codigoExistente = carga.value.some(item => item[0] === selectedInventario.value.codigo_inventario);
    if (codigoExistente) {
        addError.value = 'El producto ya ha sido agregado.';
        return; // Salir de la función si el producto ya existe
    }
    // Resetear el mensaje de error
    addError.value = '';
    const kilosnetos = cantidadSolicitada.value * 20;
    const librasnetas = parseFloat((kilosnetos * 2.20462).toFixed(2));
    const newData = [
        selectedInventario.value.codigo_inventario,
        selectedInventario.value.nombre_inventario,
        selectedInventario.value.lote,
        descripcion.value,
        cantidadSolicitada.value,
        kilosnetos,
        librasnetas,
        selectedInventario.value.receta,
        selectedInventario.value.id_kardex,
    ];
    carga.value.push(newData);
    descripcion.value = 'Cajas de Almendras';
    selectedInventario.value = '';
    cantidadSolicitada.value = '';
}
};
form.carga = carga.value;

const remove = (index) => {
    carga.value.splice(index, 1);
  };

  const submitForm = () => {
    if (validateCarga()) {
        const alerta = Swal.mixin({
            buttonsStyling: true,
        });

        alerta.fire({
            title: '¿Está seguro de enviar la solicitud?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-check"></i> Si, enviar.',
            cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar.',
        }).then((result) => {
            if (result.isConfirmed) {
                // Envía el formulario si el usuario confirma
                const formData = {
                    planta_id: props.planta.planta_id,
                    carga: form.carga, // Envía los datos de carga desde el formulario
                };

                axios.post(route('solicitudAlmacen.store'), formData)
                    .then(response => {
                        console.log(response);
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Solicitud enviada exitosamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            // Opcional: redirigir a otra página después de cerrar el Swal
                            window.location.href = route('solicitudAlmacen.index'); // Ajusta según sea necesario
                        });
                    })
                    .catch(error => {
                        console.error('Error al enviar la solicitud:', error);
                        let errorMessage = 'Ocurrió un error al enviar la solicitud.';

                        // Manejo de errores específicos
                        if (error.response && error.response.status === 422) {
                            errorMessage = 'Por favor, corrige los errores en el formulario.';
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
            }
        });
    }
};

//funciones para mostrar la cantidad en el input
const selectedInventario = ref('');
const cantidadSolicitada = ref('');
const cantidadError = ref('');
const addError = ref('');
const message = ref('');
const showMessage = ref(false);

const validateInputs = () => {
    if (!selectedInventario.value) {
        showMessageWithText('Por favor, seleccione un producto.');
        return false;
    }
    if (cantidadSolicitada.value <= 0) {
        showMessageWithText('La cantidad solicitada tiene que ser mayor a cero.');
        return false;
    }
    if (cantidadSolicitada.value > selectedInventario.value.cantidad) {
        showMessageWithText('La cantidad solicitada supera la cantidad disponible.');
        return false;
    }
    return true;
};

const validateCarga = () => {
    if (carga.value.length === 0) {
        showMessageWithText('Por favor, agregue al menos una carga.');
        return false;
    }
    return true;
}

const showMessageWithText = (text) => {
    message.value = text;
    showMessage.value = true;
    setTimeout(() => {
        showMessage.value = false;
    }, 5000);
};

const selectedInventarioData = computed(() => {
  return selectedInventario.value || { codigo_inventario: '', nombre_inventario: '', cantidad: 0 };
});

function updateSelectedInventarioData() {
  // Resetear cantidad solicitada y error al cambiar el producto
  cantidadSolicitada.value = 0;
  cantidadError.value = '';
}

function validateCantidadSolicitada() {

  if (cantidadSolicitada.value < 0) {
  cantidadError.value = 'La cantidad solicitada no puede ser cero o negativa.';
  } else {
    if (selectedInventario.value && cantidadSolicitada.value > selectedInventario.value.cantidad) {
    cantidadError.value = 'La cantidad solicitada no puede ser mayor que la cantidad actual.';
    } else {
    cantidadError.value = '';
    }
  }
}
</script>

<template>
    <Head title="Crear Conocimiento"/>
    <AuthenticatedLayout>
        <template #header>
            Crear Solicitud de Carga Almacen - {{ props.planta.nombre }}
        </template>
    <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
        <div class="px-4 py-3 flex">
            <div class="mx-1">
                    <Link :href="route('solicitudAlmacen.index')"
                    class="inline-block rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-400 text-sm">
                    <i class="fa-solid fa-left-long" style="color: #ffffff;"></i> Volver
                    </Link>
            </div>
            <div class="mx-1">
                <GreenButton @click.prevent="submitForm(solicitudcarga)">
                <i class="fa-solid fa-save"></i> Realizar Solicitud de Carga Almacen</GreenButton>
            </div>
        </div>
    </div>
    {{ props.planta }}
    <div class="min-w-full overflow-x-auto rounded-lg shadow">
        <div class="w-full whitespace-no-wrap">
            <div class="border-b bg-gray-50 text-left text-xs tracking-wide text-gray-500">
                <div class="border-b-2 px-6 py-4 text-left text-xs tracking-wider">
                    <InputLabel value="Datos de Inventario" class="text-lg font-maximo pb-2 border-b border-gray-300"/><br>
                    <table class="w-full border-collapse font-semibold uppercase">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2">Codigo</th>
                                <th class="px-4 py-2">Nombre</th>
                                <th class="px-4 py-2">Lote</th>
                                <th class="px-4 py-2">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="inv, i in inventarioAlmacenes" :key="inv.id" class="border-b">
                                <td class="px-4 py-2"> {{ inv.codigo_producto }} </td>
                                <td class="px-4 py-2"> {{ inv.articulo }} </td>
                                <td class="px-4 py-2"> {{ inv.lote }} </td>
                                <td class="px-4 py-2"> {{ inv.saldo }} </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>* Productos que fueron recepcionados en Almacen</p>
                </div>
            </div>
        </div>
    </div>
    <br>
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
                    <InputLabel value="Datos de Carga" class="text-lg font-maximo pb-2 border-b border-gray-300"></InputLabel>
                    <form @submit.prevent="submitForm">
                        <br>
                            <div class="grid grid-cols-5 gap-1 mt-2">
                                <div class="col-span-2">
                                    <InputLabel for="producto_id" value="Producto"></InputLabel>
                                    <select id="planta_id" v-model="selectedInventario"
                                    @change="updateSelectedInventarioData"
                                    class="mt-1 block w-full rounded-md">
                                        <option value="">-- Seleccione una opción --</option>
                                        <option v-for="inventarioAlmacen in inventarioAlmacenes"
                                        :key="inventarioAlmacen.rece_codigo"
                                        :value="{id_kardex:inventarioAlmacen.id,
                                                codigo_inventario:inventarioAlmacen.codigo_producto,
                                                nombre_inventario:inventarioAlmacen.articulo,
                                                lote:inventarioAlmacen.lote,
                                                cantidad: Math.floor(inventarioAlmacen.saldo),
                                                receta:inventarioAlmacen.receta_id}">
                                        {{ inventarioAlmacen.articulo }} - LOTE: {{ inventarioAlmacen.lote }}</option>
                                    </select>
                                    <InputError v-if="addError" :message="addError" class="mt-2" />
                                </div>
                                <div>
                                    <InputLabel for="cantidad" value="Cantidad Actual"/>
                                    <TextDisabled id="cantidad" :value="selectedInventarioData.cantidad" disabled />
                                </div>
                                <div>
                                    <InputLabel for="cantidad_solicitada" value="Cantidad Solicitada" />
                                        <TextInput
                                            id="cantidad_solicitada"
                                            v-model="cantidadSolicitada"
                                            type="number"
                                            placeholder="Ej. 200"
                                            @input="validateCantidadSolicitada"
                                        />
                                    <InputError v-if="cantidadError" :message="cantidadError" class="mt-2" />
                                </div>
                                <div class="mt-7 block w-full">
                                    <PrimaryButton type="button" @click="add()"
                                    class="rounded-md bg-blue-600 px-2 py-2.5 text-white hover:bg-blue-500 text-sm block w-full mt-1 block w-full">
                                    <i class="fa-solid fa-truck-ramp-box px" style="color: #ffffff;"></i>
                                    Agregar
                                    </PrimaryButton>
                                </div>
                            </div>
                            <br>
                            <table class="w-full border-collapse font-semibold uppercase">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-4 py-2">Codigo</th>
                                        <th class="px-4 py-2">Producto</th>
                                        <th class="px-4 py-2">Lote</th>
                                        <th class="px-4 py-2">Descripción</th>
                                        <th class="px-4 py-2">Cantidad</th>
                                        <th class="px-4 py-2">Kilos Netos</th>
                                        <th class="px-4 py-2">Libras Netas</th>
                                        <th class="px-4 py-2">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(_, index) in carga" :key="index" class="border-b">
                                        <td class="px-4 py-2"> {{ carga[index][0] }} </td>
                                        <td class="px-4 py-2"> {{ carga[index][1] }} </td>
                                        <td class="px-4 py-2"> {{ carga[index][2] }} </td>
                                        <td class="px-4 py-2"> {{ carga[index][3] }} </td>
                                        <td class="px-4 py-2"> {{ carga[index][4] }} </td>
                                        <td class="px-4 py-2"> {{ carga[index][5] }} </td>
                                        <td class="px-4 py-2"> {{ carga[index][6] }} </td>
                                        <td class="px-4 py-2">
                                        <WarningButton type="button" @click="remove(index, carga)">
                                        <i class="fa-solid fa-trash-can px" style="color: #ffffff;"></i>
                                        </WarningButton>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <p>* Peso de la 1 Caja de Almendras es 20kg.<br>
                                * Conversion de 1 Kilogramo es 2.20462 Libras</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
